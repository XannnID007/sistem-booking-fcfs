<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['studio', 'payments'])
            ->where('user_id', auth()->id())
            ->whereIn('status_booking', ['pending', 'dibayar'])
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('customer.booking.index', compact('bookings'));
    }

    public function create(Studio $studio)
    {
        return view('customer.booking.create', compact('studio'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'durasi_jam' => 'required|integer|min:1|max:12'
        ]);

        $jamMulai = Carbon::parse($request->jam_mulai);
        $jamSelesai = $jamMulai->copy()->addHours($request->durasi_jam);

        // Cek apakah ada booking yang bentrok (FCFS Logic)
        $conflict = Booking::where('studio_id', $request->studio_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('status_booking', '!=', 'dibatalkan')
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai->format('H:i'), $jamSelesai->format('H:i')])
                    ->orWhereBetween('jam_selesai', [$jamMulai->format('H:i'), $jamSelesai->format('H:i')])
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('jam_mulai', '<=', $jamMulai->format('H:i'))
                            ->where('jam_selesai', '>=', $jamSelesai->format('H:i'));
                    });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'available' => false,
                'message' => 'Maaf, jadwal tersebut sudah dibooking. Silakan pilih waktu lain.'
            ]);
        }

        $studio = Studio::find($request->studio_id);
        $totalHarga = $studio->harga_per_jam * $request->durasi_jam;

        return response()->json([
            'available' => true,
            'total_harga' => $totalHarga,
            'message' => 'Jadwal tersedia! Silakan lanjutkan ke pembayaran.'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'durasi_jam' => 'required|integer|min:1|max:12',
            'catatan' => 'nullable|string|max:500',
            'jumlah_bayar' => 'required|numeric|min:1',
            'tipe_pembayaran' => 'required|in:dp,lunas',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $jamMulai = Carbon::parse($validated['jam_mulai']);
        $jamSelesai = $jamMulai->copy()->addHours($validated['durasi_jam']);

        try {
            DB::beginTransaction();

            // Double check availability dengan lock (FCFS Critical Section)
            $conflict = Booking::where('studio_id', $validated['studio_id'])
                ->where('tanggal_booking', $validated['tanggal_booking'])
                ->where('status_booking', '!=', 'dibatalkan')
                ->where(function ($query) use ($jamMulai, $jamSelesai) {
                    $query->whereBetween('jam_mulai', [$jamMulai->format('H:i'), $jamSelesai->format('H:i')])
                        ->orWhereBetween('jam_selesai', [$jamMulai->format('H:i'), $jamSelesai->format('H:i')])
                        ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                            $q->where('jam_mulai', '<=', $jamMulai->format('H:i'))
                                ->where('jam_selesai', '>=', $jamSelesai->format('H:i'));
                        });
                })
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Maaf, jadwal tersebut baru saja dibooking oleh orang lain. Silakan pilih waktu lain.');
            }

            $studio = Studio::findOrFail($validated['studio_id']);
            $totalHarga = $studio->harga_per_jam * $validated['durasi_jam'];

            // Buat booking baru
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'studio_id' => $validated['studio_id'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'jam_mulai' => $jamMulai->format('H:i'),
                'jam_selesai' => $jamSelesai->format('H:i'),
                'durasi_jam' => $validated['durasi_jam'],
                'total_harga' => $totalHarga,
                'status_booking' => 'pending',
                'catatan' => $validated['catatan']
            ]);

            // Upload bukti transfer
            $file = $request->file('bukti_transfer');
            $filename = 'payment_' . time() . '_' . $booking->id . '.' . $file->extension();
            $file->move(public_path('uploads/payments'), $filename);

            // Buat record pembayaran
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'jumlah_bayar' => $validated['jumlah_bayar'],
                'tipe_pembayaran' => $validated['tipe_pembayaran'],
                'metode_pembayaran' => 'qris',
                'status_pembayaran' => 'pending',
                'bukti_transfer' => $filename
            ]);

            // Send notification to all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createBookingNotification($admin->id, $booking);
                Notification::createPaymentNotification($admin->id, $payment);
            }

            DB::commit();

            return redirect()->route('customer.booking.show', $booking->id)
                ->with('success', 'Booking berhasil! Menunggu verifikasi pembayaran dari admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function show(Booking $booking)
    {
        // Pastikan user hanya bisa lihat booking miliknya sendiri
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['studio', 'payments']);

        // Hitung total bayar dan sisa
        $totalBayar = $booking->payments()
            ->where('status_pembayaran', 'terverifikasi')
            ->sum('jumlah_bayar');

        $sisaBayar = $booking->total_harga - $totalBayar;

        return view('customer.booking.show', compact('booking', 'totalBayar', 'sisaBayar'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status_booking === 'dibayar') {
            return redirect()->back()->with('error', 'Booking yang sudah dibayar tidak bisa dibatalkan.');
        }

        $booking->update(['status_booking' => 'dibatalkan']);

        return redirect()->route('customer.booking.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function history()
    {
        $bookings = Booking::with(['studio', 'payments'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.booking.history', compact('bookings'));
    }

    public function historyDetail(Booking $booking)
    {
        // Pastikan user hanya bisa lihat booking miliknya sendiri
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['studio', 'payments.verifikator']);

        // Hitung total bayar
        $totalBayar = $booking->payments()
            ->where('status_pembayaran', 'terverifikasi')
            ->sum('jumlah_bayar');

        return view('customer.booking.history-detail', compact('booking', 'totalBayar'));
    }
}
