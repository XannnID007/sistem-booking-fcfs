@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Monitoring data booking dan pembayaran')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Studio</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalStudio }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-lg"><svg class="w-6 h-6 text-amber-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">...</svg></div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Customer</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCustomer }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg"><svg class="w-6 h-6 text-blue-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">...</svg></div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Booking Hari Ini</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $bookingHariIni }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg"><svg class="w-6 h-6 text-green-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">...</svg></div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-slate-800 mt-2">Rp
                        {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg"><svg class="w-6 h-6 text-indigo-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">...</svg></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Booking Terbaru</h3>
                    <a href="{{ route('admin.booking.index') }}"
                        class="text-sm font-semibold text-amber-600 hover:underline">Lihat Semua</a>
                </div>
                @if ($bookingTerbaru->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-600">Customer</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-600">Studio</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-600">Tanggal</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-600">Status</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-600">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($bookingTerbaru as $booking)
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4 font-medium text-slate-800">{{ $booking->user->name }}</td>
                                        <td class="py-3 px-4 text-slate-600">{{ $booking->studio->nama_studio }}</td>
                                        <td class="py-3 px-4 text-slate-600">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if ($booking->status_booking == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Pending</span>
                                            @elseif($booking->status_booking == 'dibayar')
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Dibayar</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-slate-100 text-slate-800 rounded text-xs font-semibold">{{ ucfirst($booking->status_booking) }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right font-medium text-slate-800">Rp
                                            {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-slate-500">Belum ada booking terbaru.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Menunggu Verifikasi</h3>
                    <a href="{{ route('admin.payment.index') }}"
                        class="text-sm font-semibold text-amber-600 hover:underline">Lihat</a>
                </div>
                @if ($pembayaranMenunggu->count() > 0)
                    <div class="space-y-4">
                        @foreach ($pembayaranMenunggu as $payment)
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $payment->booking->user->name }}</p>
                                    <p class="text-sm font-bold text-slate-800">Rp
                                        {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                </div>
                                <p class="text-xs text-slate-500">{{ $payment->booking->studio->nama_studio }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-slate-500">Tidak ada pembayaran yang menunggu verifikasi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
