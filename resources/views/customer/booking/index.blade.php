@extends('layouts.customer')

@section('title', 'Booking Saya')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Booking Aktif</h1>
                <p class="text-sm text-slate-600 mt-1">Kelola booking studio Anda</p>
            </div>

            @if ($bookings->count() > 0)
                <div class="space-y-4">
                    @foreach ($bookings as $booking)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-slate-200">
                            <div class="p-5">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h2 class="text-lg font-bold text-slate-900">
                                                {{ $booking->studio->nama_studio }}
                                            </h2>
                                            @if ($booking->status_booking == 'pending')
                                                <span
                                                    class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">
                                                    Pending
                                                </span>
                                            @elseif($booking->status_booking == 'dibayar')
                                                <span
                                                    class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs font-bold">
                                                    Aktif
                                                </span>
                                            @endif
                                        </div>

                                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                            <div class="flex items-center text-slate-600">
                                                <svg class="w-4 h-4 mr-1.5 text-amber-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </div>
                                            <div class="flex items-center text-slate-600">
                                                <svg class="w-4 h-4 mr-1.5 text-amber-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-amber-50 rounded-lg p-3 text-right border border-amber-200 ml-4">
                                        <p class="text-xs text-slate-600">Total</p>
                                        <p class="text-xl font-bold text-amber-600">
                                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                    @php
                                        $totalBayar = $booking
                                            ->payments()
                                            ->where('status_pembayaran', 'terverifikasi')
                                            ->sum('jumlah_bayar');
                                        $pendingPayment = $booking
                                            ->payments()
                                            ->where('status_pembayaran', 'pending')
                                            ->first();
                                    @endphp

                                    <div class="flex items-center text-sm">
                                        @if ($totalBayar >= $booking->total_harga)
                                            <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-semibold text-green-600">Lunas</span>
                                        @elseif($pendingPayment)
                                            <svg class="w-4 h-4 mr-1.5 text-yellow-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-semibold text-yellow-600">Verifikasi</span>
                                        @else
                                            <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-semibold text-red-600">Belum Bayar</span>
                                        @endif
                                    </div>

                                    <div class="flex gap-2">
                                        @if ($booking->status_booking == 'pending')
                                            <form action="{{ route('customer.booking.cancel', $booking->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('customer.booking.show', $booking->id) }}"
                                            class="px-4 py-1.5 bg-slate-900 text-white rounded-lg hover:bg-amber-600 transition-colors text-sm font-medium">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Booking</h3>
                    <p class="text-sm text-slate-500 mb-4">Mulai booking studio sekarang</p>
                    <a href="{{ route('customer.studio.index') }}"
                        class="inline-block px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors text-sm font-semibold">
                        Cari Studio
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
