@extends('layouts.customer')

@section('title', 'Detail Riwayat Booking')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <a href="{{ route('customer.booking.history') }}"
            class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Riwayat
        </a>

        <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-6 border-b border-gray-200">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Detail Riwayat Booking</h1>
                    <p class="text-sm text-gray-500">ID Booking: #{{ $booking->id }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    @if ($booking->status_booking == 'pending')
                        <span
                            class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold text-sm">Pending</span>
                    @elseif($booking->status_booking == 'dibayar')
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold text-sm">Dibayar</span>
                    @elseif($booking->status_booking == 'selesai')
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm">Selesai</span>
                    @else
                        <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold text-sm">Dibatalkan</span>
                    @endif
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Studio</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $booking->studio->nama_studio }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->studio->lokasi }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Tanggal Booking</h3>
                        <p class="text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Waktu</h3>
                        <p class="text-gray-800">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                        <p class="text-sm text-gray-600">Durasi: {{ $booking->durasi_jam }} jam</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Total Harga</h3>
                        <p class="text-2xl font-bold text-teal-600">Rp
                            {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Total Terbayar</h3>
                        <p class="text-lg font-semibold text-green-600">Rp
                            {{ number_format($totalBayar, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">Tanggal Dibuat</h3>
                        <p class="text-gray-800">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if ($booking->catatan)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 mb-2">Catatan</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-800">{{ $booking->catatan }}</p>
                    </div>
                </div>
            @endif

            <!-- Riwayat Pembayaran -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pembayaran</h3>

                @if ($booking->payments->count() > 0)
                    <div class="space-y-4">
                        @foreach ($booking->payments as $payment)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-col md:flex-row md:items-center justify-between mb-3">
                                    <div>
                                        <p class="font-bold text-lg text-gray-800">Rp
                                            {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $payment->tipe_pembayaran == 'dp' ? 'Down Payment (DP)' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}
                                            • {{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                    <div class="mt-3 md:mt-0">
                                        @if ($payment->status_pembayaran == 'pending')
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($payment->status_pembayaran == 'terverifikasi')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                ✓ Terverifikasi
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                ✗ Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if ($payment->status_pembayaran == 'terverifikasi' && $payment->tanggal_verifikasi)
                                    <div class="text-xs text-gray-600 bg-white rounded p-2 border border-gray-200">
                                        <span class="font-semibold">Diverifikasi:</span>
                                        {{ \Carbon\Carbon::parse($payment->tanggal_verifikasi)->format('d M Y, H:i') }}
                                        @if ($payment->verifikator)
                                            oleh {{ $payment->verifikator->name }}
                                        @endif
                                    </div>
                                @endif

                                @if ($payment->catatan_admin)
                                    <div class="mt-3 p-3 bg-blue-50 rounded border border-blue-200">
                                        <p class="text-xs font-semibold text-blue-800 mb-1">Catatan Admin:</p>
                                        <p class="text-sm text-blue-700">{{ $payment->catatan_admin }}</p>
                                    </div>
                                @endif

                                @if ($payment->bukti_transfer)
                                    <div class="mt-3">
                                        <a href="{{ asset('uploads/payments/' . $payment->bukti_transfer) }}"
                                            target="_blank"
                                            class="inline-flex items-center text-sm text-teal-600 hover:text-teal-700 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat Bukti Transfer
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-6 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg p-5 border border-teal-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Harga</p>
                                <p class="text-lg font-bold text-gray-800">Rp
                                    {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Terbayar</p>
                                <p class="text-lg font-bold text-green-600">Rp
                                    {{ number_format($totalBayar, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @php
                            $sisaBayar = $booking->total_harga - $totalBayar;
                        @endphp
                        <div class="border-t border-teal-300 mt-4 pt-4">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold text-gray-700">Status Pembayaran:</p>
                                @if ($sisaBayar <= 0)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                        ✓ LUNAS
                                    </span>
                                @else
                                    <span class="text-lg font-bold text-red-600">
                                        Sisa: Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">Tidak ada riwayat pembayaran</p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('customer.booking.history') }}"
                    class="flex-1 text-center px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                    Kembali ke Riwayat
                </a>
                @if ($booking->status_booking == 'selesai')
                    <button
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg hover:from-teal-700 hover:to-cyan-700 transition font-medium">
                        Booking Lagi
                    </button>
                @endif
            </div>
        </div>

    </div>
@endsection
