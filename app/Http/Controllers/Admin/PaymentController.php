<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.studio']);

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.payment.index', compact('payments'));
    }

    public function verify(Request $request, Payment $payment)
    {
        try {
            DB::beginTransaction();

            $payment->update([
                'status_pembayaran' => 'terverifikasi',
                'tanggal_verifikasi' => now(),
                'verifikasi_oleh' => auth()->id(),
                'catatan_admin' => $request->catatan_admin
            ]);

            // Update status booking
            $booking = $payment->booking;

            // Cek apakah pembayaran sudah lunas
            $totalDibayar = $booking->payments()
                ->where('status_pembayaran', 'terverifikasi')
                ->sum('jumlah_bayar');

            if ($totalDibayar >= $booking->total_harga) {
                $booking->update(['status_booking' => 'dibayar']);
            }

            // Send notification to customer
            Notification::createPaymentVerifiedNotification($booking->user_id, $payment);

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran.');
        }
    }

    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $payment->update([
                'status_pembayaran' => 'ditolak',
                'tanggal_verifikasi' => now(),
                'verifikasi_oleh' => auth()->id(),
                'catatan_admin' => $request->catatan_admin
            ]);

            // Send notification to customer
            Notification::createPaymentRejectedNotification($payment->booking->user_id, $payment);

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak pembayaran.');
        }
    }

    public function storePelunasan(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'catatan_admin' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($validated['booking_id']);

            // Buat payment pelunasan
            $payment = Payment::create([
                'booking_id' => $validated['booking_id'],
                'jumlah_bayar' => $validated['jumlah_bayar'],
                'tipe_pembayaran' => 'pelunasan',
                'metode_pembayaran' => 'cash',
                'status_pembayaran' => 'terverifikasi',
                'tanggal_verifikasi' => now(),
                'verifikasi_oleh' => auth()->id(),
                'catatan_admin' => $validated['catatan_admin']
            ]);

            // Cek total pembayaran
            $totalDibayar = $booking->payments()
                ->where('status_pembayaran', 'terverifikasi')
                ->sum('jumlah_bayar');

            if ($totalDibayar >= $booking->total_harga) {
                $booking->update(['status_booking' => 'dibayar']);
            }

            // Send notification to customer
            Notification::createPaymentVerifiedNotification($booking->user_id, $payment);

            DB::commit();

            return redirect()->back()->with('success', 'Pelunasan berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mencatat pelunasan.');
        }
    }
}
