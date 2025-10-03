@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Riwayat Booking</h1>
                <p class="text-sm text-slate-600 mt-1">Semua riwayat booking studio Anda</p>
            </div>

            @if ($bookings->count() > 0)
                <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Studio</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Waktu</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($bookings as $booking)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3">
                                            <p class="font-semibold text-slate-900">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                Dibuat: {{ $booking->created_at->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="font-semibold text-slate-900">{{ $booking->studio->nama_studio }}</p>
                                            <p class="text-xs text-slate-600">{{ Str::limit($booking->studio->lokasi, 25) }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="text-slate-900">{{ $booking->jam_mulai }} -
                                                {{ $booking->jam_selesai }}</p>
                                            <p class="text-xs text-slate-500">{{ $booking->durasi_jam }} jam</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="font-bold text-slate-900">
                                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                            </p>
                                            @php
                                                $totalBayar = $booking
                                                    ->payments()
                                                    ->where('status_pembayaran', 'terverifikasi')
                                                    ->sum('jumlah_bayar');
                                            @endphp
                                            @if ($totalBayar > 0)
                                                <p class="text-xs text-green-600">
                                                    Bayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($booking->status_booking == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">
                                                    Pending
                                                </span>
                                            @elseif($booking->status_booking == 'dibayar')
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">
                                                    Dibayar
                                                </span>
                                            @elseif($booking->status_booking == 'selesai')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-bold">
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-bold">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('customer.booking.history.detail', $booking->id) }}"
                                                class="text-amber-600 hover:text-amber-700 font-semibold text-xs">
                                                Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-sm text-slate-500 mb-4">Anda belum memiliki riwayat booking</p>
                    <a href="{{ route('customer.studio.index') }}"
                        class="inline-block px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors text-sm font-semibold">
                        Mulai Booking
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
