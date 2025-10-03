@extends('layouts.customer')

@section('title', 'Detail Riwayat')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('customer.booking.history') }}"
                class="inline-flex items-center text-sm text-amber-600 hover:text-amber-700 mb-6 font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-6 border-b border-slate-200">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 mb-1">Detail Riwayat Booking</h1>
                        <p class="text-sm text-slate-500">ID: #{{ $booking->id }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if ($booking->status_booking == 'pending')
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-bold text-sm">
                                Pending
                            </span>
                        @elseif($booking->status_booking == 'dibayar')
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold text-sm">
                                Dibayar
                            </span>
                        @elseif($booking->status_booking == 'selesai')
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-bold text-sm">
                                Selesai
                            </span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold text-sm">
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Studio</h3>
                            <p class="text-base font-bold text-slate-900">{{ $booking->studio->nama_studio }}</p>
                            <p class="text-sm text-slate-600">{{ $booking->studio->lokasi }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Tanggal Booking</h3>
                            <p class="text-sm text-slate-900">
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Waktu</h3>
                            <p class="text-sm text-slate-900">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                            <p class="text-xs text-slate-600">Durasi: {{ $booking->durasi_jam }} jam</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Total Harga</h3>
                            <p class="text-2xl font-bold text-amber-600">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Total Terbayar</h3>
                            <p class="text-lg font-bold text-green-600">
                                Rp {{ number_format($totalBayar, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-500 mb-1">Tanggal Dibuat</h3>
                            <p class="text-sm text-slate-900">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if ($booking->catatan)
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-slate-500 mb-2">Catatan</h3>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <p class="text-sm text-slate-800">{{ $booking->catatan }}</p>
                        </div>
                    </div>
                @endif

                <!-- Riwayat Pembayaran -->
                <div class="border-t pt-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4">Riwayat Pembayaran</h3>

                    @if ($booking->payments->count() > 0)
                        <div class="space-y-3">
                            @foreach ($booking->payments as $payment)
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-3">
                                        <div>
                                            <p class="font-bold text-base text-slate-900">
                                                Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-slate-600 mt-1">
                                                {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}
                                                • {{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, H:i') }} WIB
                                            </p>
                                        </div>
                                        <div class="mt-3 md:mt-0">
                                            @if ($payment->status_pembayaran == 'pending')
                                                <span
                                                    class="px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-bold">
                                                    Pending
                                                </span>
                                            @elseif($payment->status_pembayaran == 'terverifikasi')
                                                <span
                                                    class="px-3 py-1.5 bg-green-100 text-green-800 rounded-lg text-xs font-bold">
                                                    ✓ Terverifikasi
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1.5 bg-red-100 text-red-800 rounded-lg text-xs font-bold">
                                                    ✗ Ditolak
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($payment->status_pembayaran == 'terverifikasi' && $payment->tanggal_verifikasi)
                                        <div
                                            class="text-xs text-slate-600 bg-white rounded p-2 border border-slate-200 mb-2">
                                            <span class="font-semibold">Diverifikasi:</span>
                                            {{ \Carbon\Carbon::parse($payment->tanggal_verifikasi)->format('d M Y, H:i') }}
                                            @if ($payment->verifikator)
                                                oleh {{ $payment->verifikator->name }}
                                            @endif
                                        </div>
                                    @endif

                                    @if ($payment->catatan_admin)
                                        <div class="p-3 bg-blue-50 rounded border border-blue-200">
                                            <p class="text-xs font-bold text-blue-900 mb-1">Catatan Admin:</p>
                                            <p class="text-xs text-blue-700">{{ $payment->catatan_admin }}</p>
                                        </div>
                                    @endif

                                    @if ($payment->bukti_transfer)
                                        <div class="mt-3">
                                            <a href="{{ asset('uploads/payments/' . $payment->bukti_transfer) }}"
                                                target="_blank"
                                                class="inline-flex items-center text-xs text-amber-600 hover:text-amber-700 font-semibold">
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
                        <div class="mt-6 bg-amber-50 rounded-lg p-4 border border-amber-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-slate-600">Total Harga</p>
                                    <p class="text-base font-bold text-slate-900">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-600">Total Terbayar</p>
                                    <p class="text-base font-bold text-green-600">
                                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @php
                                $sisaBayar = $booking->total_harga - $totalBayar;
                            @endphp
                            <div class="border-t border-amber-300 mt-4 pt-4">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold text-slate-800 text-sm">Status:</p>
                                    @if ($sisaBayar <= 0)
                                        <span class="px-3 py-1 bg-green-500 text-white rounded-lg text-xs font-bold">
                                            ✓ LUNAS
                                        </span>
                                    @else
                                        <span class="text-base font-bold text-red-600">
                                            Sisa: Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 bg-slate-50 rounded-lg">
                            <p class="text-sm text-slate-500">Tidak ada riwayat pembayaran</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t">
                    <a href="{{ route('customer.booking.history') }}"
                        class="flex-1 text-center px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium text-sm">
                        Kembali ke Riwayat
                    </a>
                    @if ($booking->status_booking == 'selesai')
                        <a href="{{ route('customer.studio.index') }}"
                            class="flex-1 text-center px-6 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition font-medium text-sm">
                            Booking Lagi
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
