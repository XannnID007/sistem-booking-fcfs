@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Monitoring data booking dan pembayaran')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Studio -->
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-teal-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Studio</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalStudio }}</p>
                </div>
                <div class="w-14 h-14 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Customer -->
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-cyan-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Customer</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCustomer }}</p>
                </div>
                <div class="w-14 h-14 bg-cyan-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Booking Hari Ini -->
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Booking Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $bookingHariIni }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Booking Terbaru -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Booking Terbaru</h3>
                    <a href="{{ route('admin.booking.index') }}"
                        class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                @if ($bookingTerbaru->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Customer</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Studio</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tanggal</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Status</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookingTerbaru as $booking)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-2">
                                            <p class="text-sm font-medium text-gray-800">{{ $booking->user->name }}</p>
                                        </td>
                                        <td class="py-3 px-2">
                                            <p class="text-sm text-gray-600">{{ $booking->studio->nama_studio }}</p>
                                        </td>
                                        <td class="py-3 px-2">
                                            <p class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $booking->jam_mulai }} -
                                                {{ $booking->jam_selesai }}</p>
                                        </td>
                                        <td class="py-3 px-2">
                                            @if ($booking->status_booking == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">Pending</span>
                                            @elseif($booking->status_booking == 'dibayar')
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Dibayar</span>
                                            @elseif($booking->status_booking == 'selesai')
                                                <span
                                                    class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">Selesai</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-2">
                                            <p class="text-sm font-medium text-gray-800">Rp
                                                {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada booking</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pembayaran Menunggu Verifikasi -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Verifikasi Pembayaran</h3>
                    <a href="{{ route('admin.payment.index') }}"
                        class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                        Lihat →
                    </a>
                </div>

                @if ($pembayaranMenunggu->count() > 0)
                    <div class="space-y-4">
                        @foreach ($pembayaranMenunggu as $payment)
                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-800">{{ $payment->booking->user->name }}
                                        </p>
                                        <p class="text-xs text-gray-600">{{ $payment->booking->studio->nama_studio }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-800">Rp
                                        {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                    <a href="{{ route('admin.payment.index') }}"
                                        class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                                        Verifikasi →
                                    </a>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Tidak ada pembayaran<br>menunggu verifikasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
