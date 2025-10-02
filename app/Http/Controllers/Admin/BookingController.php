<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'studio']);

        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_booking', $request->tanggal);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(15);

        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'studio', 'payments.verifikator']);

        // Hitung total bayar dan sisa
        $totalBayar = $booking->payments()
            ->where('status_pembayaran', 'terverifikasi')
            ->sum('jumlah_bayar');

        $sisaBayar = $booking->total_harga - $totalBayar;

        return view('admin.booking.show', compact('booking', 'totalBayar', 'sisaBayar'));
    }

    public function markComplete(Booking $booking)
    {
        if ($booking->status_booking !== 'dibayar') {
            return redirect()->back()->with('error', 'Hanya booking yang sudah dibayar yang bisa diselesaikan.');
        }

        $booking->update(['status_booking' => 'selesai']);

        return redirect()->back()->with('success', 'Booking berhasil diselesaikan.');
    }
}
