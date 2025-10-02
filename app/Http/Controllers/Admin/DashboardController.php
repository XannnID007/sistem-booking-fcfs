<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudio = Studio::count();
        $totalCustomer = User::where('role', 'customer')->count();
        $bookingHariIni = Booking::whereDate('tanggal_booking', today())->count();
        $pendapatanBulanIni = Payment::whereMonth('created_at', Carbon::now()->month)
            ->where('status_pembayaran', 'terverifikasi')
            ->sum('jumlah_bayar');

        $bookingTerbaru = Booking::with(['user', 'studio'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $pembayaranMenunggu = Payment::with(['booking.user', 'booking.studio'])
            ->where('status_pembayaran', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudio',
            'totalCustomer',
            'bookingHariIni',
            'pendapatanBulanIni',
            'bookingTerbaru',
            'pembayaranMenunggu'
        ));
    }
}
