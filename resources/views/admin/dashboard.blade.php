@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name)

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Studio -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Studio</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalStudio }}</p>
                    <p class="text-xs text-green-600 mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Studio Aktif
                    </p>
                </div>
                <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Customer -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Customer</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalCustomer }}</p>
                    <p class="text-xs text-blue-600 mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Pengguna Terdaftar
                    </p>
                </div>
                <div class="p-3 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Booking Hari Ini -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Booking Hari Ini</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $bookingHariIni }}</p>
                    <p class="text-xs text-purple-600 mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ date('d M Y') }}
                    </p>
                </div>
                <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-green-100 mb-1">Pendapatan</p>
                    <p class="text-3xl font-bold">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-100 mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Total Terverifikasi
                    </p>
                </div>
                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Booking Terbaru</h3>
                    <p class="text-sm text-slate-500 mt-1">10 booking terakhir</p>
                </div>
                <a href="{{ route('admin.booking.index') }}"
                    class="text-sm font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if ($bookingTerbaru->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left py-3 px-6 text-xs font-semibold text-slate-600">Customer</th>
                                <th class="text-left py-3 px-6 text-xs font-semibold text-slate-600">Studio</th>
                                <th class="text-left py-3 px-6 text-xs font-semibold text-slate-600">Tanggal</th>
                                <th class="text-left py-3 px-6 text-xs font-semibold text-slate-600">Status</th>
                                <th class="text-right py-3 px-6 text-xs font-semibold text-slate-600">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($bookingTerbaru as $booking)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span
                                                    class="text-white font-bold text-xs">{{ substr($booking->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-sm text-slate-900">{{ $booking->user->name }}
                                                </p>
                                                <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <p class="text-sm font-medium text-slate-900">{{ $booking->studio->nama_studio }}
                                        </p>
                                        <p class="text-xs text-slate-500">{{ Str::limit($booking->studio->lokasi, 20) }}
                                        </p>
                                    </td>
                                    <td class="py-3 px-6">
                                        <p class="text-sm text-slate-900">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                        <p class="text-xs text-slate-500">{{ $booking->jam_mulai }}</p>
                                    </td>
                                    <td class="py-3 px-6">
                                        @if ($booking->status_booking == 'pending')
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-semibold">Pending</span>
                                        @elseif($booking->status_booking == 'dibayar')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-semibold">Dibayar</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-slate-100 text-slate-700 rounded-md text-xs font-semibold">{{ ucfirst($booking->status_booking) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-right">
                                        <p class="text-sm font-bold text-slate-900">Rp
                                            {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p class="text-slate-500 text-sm">Belum ada booking</p>
                </div>
            @endif
        </div>

        <!-- Pembayaran Menunggu Verifikasi -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Menunggu Verifikasi</h3>
                <p class="text-sm text-slate-500 mt-1">Pembayaran pending</p>
            </div>

            @if ($pembayaranMenunggu->count() > 0)
                <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                    @foreach ($pembayaranMenunggu as $payment)
                        <div
                            class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg border border-amber-200 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-900">{{ $payment->booking->user->name }}</p>
                                    <p class="text-xs text-slate-600 mt-1">{{ $payment->booking->studio->nama_studio }}
                                    </p>
                                </div>
                                <div
                                    class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-bold text-amber-600">Rp
                                    {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-500">{{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.payment.index') }}"
                                class="mt-3 block w-full text-center py-2 bg-white border border-amber-300 text-amber-700 rounded-lg text-xs font-semibold hover:bg-amber-50 transition-colors">
                                Verifikasi Sekarang
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-slate-500 text-sm">Semua pembayaran terverifikasi</p>
                </div>
            @endif
        </div>
    </div>

@endsection
