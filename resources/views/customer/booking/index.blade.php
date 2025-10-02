@extends('layouts.customer')

@section('title', 'Booking Saya')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Aktif</h1>
            <p class="text-gray-600">Daftar booking yang sedang aktif dan menunggu pembayaran</p>
        </div>

        @if ($bookings->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($bookings as $booking)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition">
                        <!-- Header Card -->
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-white font-bold text-lg">{{ $booking->studio->nama_studio }}</h3>
                                @if ($booking->status_booking == 'pending')
                                    <span class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>
                                @elseif($booking->status_booking == 'dibayar')
                                    <span class="px-3 py-1 bg-green-400 text-green-900 rounded-full text-xs font-semibold">
                                        Dibayar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Info Booking -->
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal</p>
                                        <p class="font-medium">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Waktu</p>
                                        <p class="font-medium">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                            ({{ $booking->durasi_jam }} jam)</p>
                                    </div>
                                </div>

                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Lokasi</p>
                                        <p class="font-medium">{{ $booking->studio->lokasi }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Harga -->
                            <div class="bg-teal-50 rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Total Harga:</span>
                                    <span class="text-2xl font-bold text-teal-600">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Status Pembayaran -->
                            @php
                                $totalBayar = $booking
                                    ->payments()
                                    ->where('status_pembayaran', 'terverifikasi')
                                    ->sum('jumlah_bayar');
                                $pendingPayment = $booking->payments()->where('status_pembayaran', 'pending')->first();
                            @endphp

                            @if ($totalBayar >= $booking->total_harga)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                                    <p class="text-green-700 text-sm font-medium">✓ Pembayaran Lunas</p>
                                </div>
                            @elseif($pendingPayment)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                    <p class="text-yellow-700 text-sm font-medium">⏳ Menunggu Verifikasi Admin</p>
                                </div>
                            @else
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                    <p class="text-red-700 text-sm font-medium">! Belum Ada Pembayaran</p>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('customer.booking.show', $booking->id) }}"
                                    class="flex-1 bg-teal-600 text-white py-2.5 rounded-lg font-medium hover:bg-teal-700 transition text-center">
                                    Lihat Detail
                                </a>
                                @if ($booking->status_booking == 'pending')
                                    <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST"
                                        class="flex-1" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl p-16 text-center shadow-md">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Booking Aktif</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki booking yang aktif</p>
                <a href="{{ route('customer.studio.index') }}"
                    class="inline-block px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                    Booking Studio Sekarang
                </a>
            </div>
        @endif

    </div>
@endsection
