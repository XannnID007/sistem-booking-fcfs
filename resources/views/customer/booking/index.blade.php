@extends('layouts.customer')

@section('title', 'Booking Saya')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Booking Aktif Saya</h1>
            <p class="mt-1 text-slate-500">Berikut adalah daftar booking Anda yang sedang aktif atau menunggu pembayaran.</p>
        </div>

        @if ($bookings->count() > 0)
            <div class="space-y-6">
                @foreach ($bookings as $booking)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
                                <div class="mb-4 sm:mb-0">
                                    <div class="flex items-center mb-3">
                                        <h2 class="text-xl font-bold text-slate-800">{{ $booking->studio->nama_studio }}
                                        </h2>
                                        @if ($booking->status_booking == 'pending')
                                            <span
                                                class="ml-3 px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold border border-yellow-200">Pending</span>
                                        @elseif($booking->status_booking == 'dibayar')
                                            <span
                                                class="ml-3 px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">Aktif</span>
                                        @endif
                                    </div>
                                    <div class="space-y-2 text-sm text-slate-600">
                                        <p class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">...</svg>
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->isoFormat('dddd, D MMMM YYYY') }}
                                        </p>
                                        <p class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">...</svg>
                                            {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                            ({{ $booking->durasi_jam }} jam)
                                        </p>
                                    </div>
                                </div>

                                <div class="text-left sm:text-right">
                                    <p class="text-sm text-slate-500">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-gold-600">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div
                                class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between">
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

                                @if ($totalBayar >= $booking->total_harga)
                                    <p class="text-sm font-semibold text-green-600 flex items-center mb-3 sm:mb-0">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">...</svg>
                                        Pembayaran Lunas
                                    </p>
                                @elseif($pendingPayment)
                                    <p class="text-sm font-semibold text-yellow-600 flex items-center mb-3 sm:mb-0">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">...</svg>
                                        Menunggu Verifikasi Pembayaran
                                    </p>
                                @else
                                    <p class="text-sm font-semibold text-red-600 flex items-center mb-3 sm:mb-0">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">...</svg>
                                        Belum Dibayar
                                    </p>
                                @endif

                                <div class="flex w-full sm:w-auto space-x-3">
                                    @if ($booking->status_booking == 'pending')
                                        <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST"
                                            class="flex-1"
                                            onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-semibold">Batalkan</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('customer.booking.show', $booking->id) }}"
                                        class="flex-1 text-center px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition text-sm font-semibold">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl p-16 text-center border border-slate-200">
                <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">...</svg>
                <h3 class="text-xl font-semibold text-slate-800 mb-1">Anda Belum Punya Booking Aktif</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">Sepertinya Anda belum memesan studio. Ayo temukan studio
                    yang tepat untuk Anda!</p>
                <a href="{{ route('customer.studio.index') }}"
                    class="inline-block px-8 py-3 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition font-bold text-sm shadow-lg">
                    Cari Studio Sekarang
                </a>
            </div>
        @endif
    </div>
@endsection
