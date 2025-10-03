@extends('layouts.customer')

@section('title', 'Detail Booking')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('customer.booking.index') }}"
                class="inline-flex items-center text-sm text-amber-600 hover:text-amber-700 mb-6 font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 space-y-5">
                    <!-- Booking Info -->
                    <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-200">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                            <h2 class="text-base font-bold text-slate-900">Detail Booking</h2>
                            @if ($booking->status_booking == 'pending')
                                <span
                                    class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold">Pending</span>
                            @elseif($booking->status_booking == 'dibayar')
                                <span
                                    class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Dibayar</span>
                            @elseif($booking->status_booking == 'selesai')
                                <span
                                    class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold">Selesai</span>
                            @else
                                <span
                                    class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Dibatalkan</span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-bold text-slate-500 mb-1">Studio</p>
                                <p class="font-bold text-sm text-slate-900">{{ $booking->studio->nama_studio }}</p>
                                <p class="text-xs text-slate-600">{{ $booking->studio->lokasi }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Tanggal</p>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Waktu</p>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                    </p>
                                </div>
                            </div>

                            @if ($booking->catatan)
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Catatan</p>
                                    <p class="text-sm text-slate-700">{{ $booking->catatan }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-700">Total Harga:</span>
                                <span class="text-2xl font-bold text-amber-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Riwayat Pembayaran</h3>

                        @if ($booking->payments->count() > 0)
                            <div class="space-y-3">
                                @foreach ($booking->payments as $payment)
                                    <div class="border border-slate-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-bold text-base text-slate-900">
                                                    Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs text-slate-600 mt-1">
                                                    {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}
                                                    • {{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}
                                                </p>
                                            </div>
                                            @if ($payment->status_pembayaran == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">Pending</span>
                                            @elseif($payment->status_pembayaran == 'terverifikasi')
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">✓
                                                    Terverifikasi</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-bold">✗
                                                    Ditolak</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500">{{ $payment->created_at->format('d M Y, H:i') }}
                                        </p>

                                        @if ($payment->catatan_admin)
                                            <div class="mt-2 p-2 bg-blue-50 rounded text-xs border border-blue-200">
                                                <p class="font-bold text-blue-900">Catatan Admin:</p>
                                                <p class="text-blue-700 mt-1">{{ $payment->catatan_admin }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if ($sisaBayar > 0)
                                <div class="bg-orange-50 border border-orange-300 rounded-lg p-3 mt-4">
                                    <p class="text-sm text-orange-800 font-bold">
                                        Sisa: Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                                    </p>
                                </div>
                            @else
                                <div class="bg-green-50 border border-green-300 rounded-lg p-3 mt-4">
                                    <p class="text-sm text-green-800 font-bold">✓ Pembayaran Lunas</p>
                                </div>
                            @endif
                        @else
                            <p class="text-sm text-slate-500 text-center py-6">Belum ada pembayaran</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-5 sticky top-20">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Status</h3>

                        @php
                            $pendingPayment = $booking->payments()->where('status_pembayaran', 'pending')->exists();
                        @endphp

                        @if ($pendingPayment)
                            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mb-4">
                                <svg class="w-10 h-10 text-yellow-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-bold text-yellow-800 text-center">Menunggu Verifikasi</p>
                            </div>
                        @elseif($sisaBayar <= 0)
                            <div class="bg-green-50 border border-green-300 rounded-lg p-4 mb-4">
                                <svg class="w-10 h-10 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-bold text-green-800 text-center">Pembayaran Lunas</p>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-300 rounded-lg p-4 mb-4">
                                <svg class="w-10 h-10 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-bold text-red-800 text-center">Belum Lunas</p>
                            </div>
                        @endif

                        <div class="space-y-2">
                            @if ($booking->status_booking == 'pending' && !$pendingPayment)
                                <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan?')">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-semibold">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('customer.booking.index') }}"
                                class="block w-full text-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors text-sm font-semibold">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
