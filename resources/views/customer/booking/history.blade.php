@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Booking</h1>
            <p class="text-gray-600">Semua riwayat booking studio musik Anda</p>
        </div>

        @if ($bookings->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Booking</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Studio</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-500">Dibuat: {{ $booking->created_at->format('d/m/Y') }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800">{{ $booking->studio->nama_studio }}</p>
                                        <p class="text-sm text-gray-600">{{ Str::limit($booking->studio->lokasi, 30) }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-800">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->durasi_jam }} jam</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800">Rp
                                            {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                        @php
                                            $totalBayar = $booking
                                                ->payments()
                                                ->where('status_pembayaran', 'terverifikasi')
                                                ->sum('jumlah_bayar');
                                        @endphp
                                        @if ($totalBayar > 0)
                                            <p class="text-xs text-teal-600">Dibayar: Rp
                                                {{ number_format($totalBayar, 0, ',', '.') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($booking->status_booking == 'pending')
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                                Pending
                                            </span>
                                        @elseif($booking->status_booking == 'dibayar')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                Dibayar
                                            </span>
                                        @elseif($booking->status_booking == 'selesai')
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('customer.booking.show', $booking->id) }}"
                                            class="text-teal-600 hover:text-teal-700 font-medium text-sm">
                                            Lihat Detail →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl p-16 text-center shadow-md">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki riwayat booking</p>
                <a href="{{ route('customer.studio.index') }}"
                    class="inline-block px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                    Mulai Booking
                </a>
            </div>
        @endif

    </div>
@endsection
