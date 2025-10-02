@extends('layouts.admin')

@section('title', 'Data Booking')
@section('page-title', 'Data Booking')
@section('page-subtitle', 'Kelola semua booking studio')

@section('content')

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form action="{{ route('admin.booking.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <!-- Filter Status -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-gray-700 text-sm font-medium mb-2">Status Booking</label>
                <select name="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Booking</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit"
                    class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.booking.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm">Pending</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Dibayar</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'dibayar')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Selesai</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'selesai')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-red-500">
            <p class="text-gray-600 text-sm">Dibatalkan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'dibatalkan')->count() }}</p>
        </div>
    </div>

    <!-- Booking Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Studio</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $booking->studio->nama_studio }}</p>
                                    <p class="text-sm text-gray-500">{{ Str::limit($booking->studio->lokasi, 30) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->jam_mulai }} -
                                        {{ $booking->jam_selesai }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->durasi_jam }} jam</p>
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
                                        <p class="text-xs text-teal-600">Terbayar: Rp
                                            {{ number_format($totalBayar, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($booking->status_booking == 'pending')
                                        <span
                                            class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($booking->status_booking == 'dibayar')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Dibayar</span>
                                    @elseif($booking->status_booking == 'selesai')
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Selesai</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="px-3 py-1.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition text-sm">
                                            Detail
                                        </a>
                                        @if ($booking->status_booking == 'dibayar')
                                            <form action="{{ route('admin.booking.complete', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Tandai booking ini sebagai selesai?')">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                                    Selesai
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500">Belum ada data booking</p>
            </div>
        @endif
    </div>

@endsection
