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
            Kembali
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Detail Booking -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Booking -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Booking</h2>
                        @if ($booking->status_booking == 'pending')
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold">Pending</span>
                        @elseif($booking->status_booking == 'dibayar')
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold">Dibayar</span>
                        @elseif($booking->status_booking == 'selesai')
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold">Selesai</span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold">Dibatalkan</span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
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
                            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
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
                                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
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

                        @php
                            $totalBayar = $booking
                                ->payments()
                                ->where('status_pembayaran', 'terverifikasi')
                                ->sum('jumlah_bayar');
                            $sisaBayar = $booking->total_harga - $totalBayar;
                        @endphp

                        @if ($sisaBayar > 0)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                                <p class="text-orange-700 text-sm font-medium">Sisa Pembayaran: Rp
                                    {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                            </div>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                                <p class="text-green-700 text-sm font-medium">✓ Pembayaran Lunas</p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-center py-4">Belum ada pembayaran</p>
                    @endif
                </div>
            </div>

            <!-- Payment Form -->
            <div class="lg:col-span-1">
                @php
                    $pendingPayment = $booking->payments()->where('status_pembayaran', 'pending')->exists();
                @endphp

                @if ($booking->status_booking != 'dibatalkan' && $sisaBayar > 0 && !$pendingPayment)
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-20">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Upload Bukti Pembayaran</h3>

                        <!-- QR Code -->
                        @if ($qrisSetting)
                            <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
                                <p class="text-sm text-gray-600 mb-3">Scan QR Code untuk pembayaran:</p>
                                <div class="bg-white p-4 rounded-lg inline-block">
                                    <img src="{{ asset('uploads/qris/' . $qrisSetting->qr_code_image) }}" alt="QR Code"
                                        class="w-48 h-48 mx-auto">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">{{ $qrisSetting->nama_merchant }}</p>
                            </div>
                        @endif

                        <form action="{{ route('customer.booking.upload', $booking->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Jumlah Bayar -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar" required min="1"
                                    max="{{ $booking->total_harga - $totalBayar }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                    placeholder="Contoh: {{ number_format($booking->total_harga, 0, ',', '.') }}">
                                <p class="text-xs text-gray-500 mt-1">Min: Rp 1 | Max: Rp
                                    {{ number_format($booking->total_harga - $totalBayar, 0, ',', '.') }}</p>
                            </div>

                            <!-- Tipe Pembayaran -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Tipe Pembayaran</label>
                                <select name="tipe_pembayaran" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="lunas">Lunas</option>
                                    <option value="dp">DP (Down Payment)</option>
                                </select>
                            </div>

                            <!-- Bukti Transfer -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" required accept="image/*"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                                Upload Bukti
                            </button>
                        </form>
                    </div>
                @elseif($pendingPayment)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-center font-semibold text-yellow-800 mb-2">Menunggu Verifikasi</h4>
                        <p class="text-center text-yellow-700 text-sm">Pembayaran Anda sedang diverifikasi oleh admin</p>
                    </div>
                @elseif($sisaBayar <= 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-center font-semibold text-green-800 mb-2">Pembayaran Lunas</h4>
                        <p class="text-center text-green-700 text-sm">Terima kasih! Pembayaran Anda sudah lunas</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
