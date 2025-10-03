@extends('layouts.admin')

@section('title', 'Data Booking')
@section('page-title', 'Data Booking')
@section('page-subtitle', 'Kelola semua data booking studio')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-slate-200">
        <form action="{{ route('admin.booking.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2">Status Booking</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2">Tanggal Booking</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                </div>
                <div class="col-span-1 md:col-span-2 flex justify-end gap-2">
                    <button type="submit"
                        class="px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold text-sm shadow-md">
                        Filter Data
                    </button>
                    <a href="{{ route('admin.booking.index') }}"
                        class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium text-sm">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-yellow-200">
            <p class="text-sm text-slate-500">Pending</p>
            <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $bookings->where('status_booking', 'pending')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-green-200">
            <p class="text-sm text-slate-500">Dibayar</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $bookings->where('status_booking', 'dibayar')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-blue-200">
            <p class="text-sm text-slate-500">Selesai</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $bookings->where('status_booking', 'selesai')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-red-200">
            <p class="text-sm text-slate-500">Dibatalkan</p>
            <p class="text-3xl font-bold text-red-600 mt-1">{{ $bookings->where('status_booking', 'dibatalkan')->count() }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Customer</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Studio</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Jadwal</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Total</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Status</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $booking->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $booking->studio->nama_studio }}</p>
                                    <p class="text-xs text-slate-500">{{ Str::limit($booking->studio->lokasi, 30) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-800">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                    <p class="text-xs text-slate-500">{{ $booking->jam_mulai }} -
                                        {{ $booking->jam_selesai }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                    @php
                                        $totalBayar = $booking
                                            ->payments()
                                            ->where('status_pembayaran', 'terverifikasi')
                                            ->sum('jumlah_bayar');
                                    @endphp
                                    @if ($totalBayar > 0)
                                        <p class="text-xs text-green-600">Terbayar: Rp
                                            {{ number_format($totalBayar, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($booking->status_booking == 'pending')
                                        <span
                                            class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold border border-yellow-200">Pending</span>
                                    @elseif($booking->status_booking == 'dibayar')
                                        <span
                                            class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">Dibayar</span>
                                    @elseif($booking->status_booking == 'selesai')
                                        <span
                                            class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold border border-blue-200">Selesai</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold border border-red-200">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition text-xs font-semibold">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-slate-500">Tidak ada data booking yang ditemukan.</p>
            </div>
        @endif
    </div>

@endsection
