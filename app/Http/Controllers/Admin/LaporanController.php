<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'studio', 'payments']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_booking', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_booking', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')->get();

        // Hitung total pendapatan (hanya yang terverifikasi)
        $totalPendapatan = 0;
        foreach ($bookings as $booking) {
            $totalPendapatan += $booking->payments()
                ->where('status_pembayaran', 'terverifikasi')
                ->sum('jumlah_bayar');
        }

        return view('admin.laporan.index', compact('bookings', 'totalPendapatan'));
    }

    public function exportExcel(Request $request)
    {
        $query = Booking::with(['user', 'studio', 'payments']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_booking', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_booking', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')->get();

        // Hitung total pendapatan
        $totalPendapatan = 0;
        foreach ($bookings as $booking) {
            $totalPendapatan += $booking->payments()
                ->where('status_pembayaran', 'terverifikasi')
                ->sum('jumlah_bayar');
        }

        $filename = 'Laporan_Booking_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new LaporanExport($bookings, $totalPendapatan), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = Booking::with(['user', 'studio', 'payments']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_booking', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_booking', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')->get();

        // Hitung total pendapatan
        $totalPendapatan = 0;
        foreach ($bookings as $booking) {
            $totalPendapatan += $booking->payments()
                ->where('status_pembayaran', 'terverifikasi')
                ->sum('jumlah_bayar');
        }

        // Data filter untuk ditampilkan di PDF
        $filters = [
            'tanggal_dari' => $request->tanggal_dari,
            'tanggal_sampai' => $request->tanggal_sampai,
            'status' => $request->status
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('bookings', 'totalPendapatan', 'filters'));

        // Set paper size dan orientation
        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_Booking_' . date('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }
}
