@extends('layouts.customer')

@section('title', 'Detail Booking')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <a href="{{ route('customer.booking.index') }}"
            class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Booking Saya
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Detail Booking -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Booking -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Booking</h2>
                        @if ($booking->status_booking == 'pending')
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold text-sm">Pending</span>
                        @elseif($booking->status_booking == 'dibayar')
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold text-sm">Dibayar</span>
                        @elseif($booking->status_booking == 'selesai')
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm">Selesai</span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold text-sm">Dibatalkan</span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Studio</p>
                                <p class="font-semibold text-gray-800 text-lg">{{ $booking->studio->nama_studio }}</p>
                                <p class="text-gray-600 text-sm">{{ $booking->studio->lokasi }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</p>
                                <p class="text-gray-600">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                    ({{ $booking->durasi_jam }} jam)</p>
                            </div>
                        </div>

                        @if ($booking->catatan)
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-500">Catatan</p>
                                    <p class="text-gray-800">{{ $booking->catatan }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="border-t mt-6 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Total Harga:</span>
                            <span class="text-3xl font-bold text-teal-600">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pembayaran -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pembayaran</h3>

                    @if ($booking->payments->count() > 0)
                        <div class="space-y-3">
                            @foreach ($booking->payments as $payment)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-medium text-gray-800">Rp
                                                {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}
                                                - {{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}
                                            </p>
                                        </div>
                                        @if ($payment->status_pembayaran == 'pending')
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                        @elseif($payment->status_pembayaran == 'terverifikasi')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Terverifikasi</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Ditolak</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $payment->created_at->format('d M Y H:i') }}</p>

                                    @if ($payment->catatan_admin)
                                        <div class="mt-2 p-2 bg-gray-50 rounded text-sm">
                                            <p class="text-gray-600"><strong>Catatan Admin:</strong>
                                                {{ $payment->catatan_admin }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if ($sisaBayar > 0)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mt-4">
                                <p class="text-orange-700 text-sm font-medium">⚠️ Sisa Pembayaran: Rp
                                    {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                            </div>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mt-4">
                                <p class="text-green-700 text-sm font-medium">✓ Pembayaran Lunas</p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-center py-4">Belum ada pembayaran</p>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>

                    @php
                        $pendingPayment = $booking->payments()->where('status_pembayaran', 'pending')->exists();
                    @endphp

                    @if ($pendingPayment)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <svg class="w-10 h-10 text-yellow-500 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="text-center font-semibold text-yellow-800 mb-1">Menunggu Verifikasi</h4>
                            <p class="text-center text-yellow-700 text-sm">Pembayaran Anda sedang diverifikasi oleh admin</p>
                        </div>
                    @elseif($sisaBayar <= 0)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="text-center font-semibold text-green-800 mb-1">Pembayaran Lunas</h4>
                            <p class="text-center text-green-700 text-sm">Terima kasih! Pembayaran Anda sudah lunas</p>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <svg class="w-10 h-10 text-red-500 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="text-center font-semibold text-red-800 mb-1">Belum Lunas</h4>
                            <p class="text-center text-red-700 text-sm">Sisa: Rp
                                {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @if ($booking->status_booking == 'pending' && !$pendingPayment)
                            <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition font-medium text-sm">
                                    Batalkan Booking
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('customer.booking.index') }}"
                            class="block w-full text-center px-4 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium text-sm">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection