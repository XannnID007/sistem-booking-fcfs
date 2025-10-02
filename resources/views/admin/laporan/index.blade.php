@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Laporan pendapatan dan booking')

@section('content')

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Filter Laporan</h3>
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Tanggal Dari -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Tanggal Sampai -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                <select name="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit"
                    class="flex-1 px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-teal-600">
            <p class="text-gray-600 text-sm mb-1">Total Booking</p>
            <p class="text-3xl font-bold text-gray-800">{{ $bookings->count() }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-600">
            <p class="text-gray-600 text-sm mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-600">
            <p class="text-gray-600 text-sm mb-1">Booking Selesai</p>
            <p class="text-3xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'selesai')->count() }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-yellow-600">
            <p class="text-gray-600 text-sm mb-1">Booking Pending</p>
            <p class="text-3xl font-bold text-gray-800">{{ $bookings->where('status_booking', 'pending')->count() }}</p>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="flex justify-end gap-3 mb-6">
        <a href="{{ route('admin.laporan.excel') }}?{{ http_build_query(request()->all()) }}"
            class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan.pdf') }}?{{ http_build_query(request()->all()) }}"
            class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                </path>
            </svg>
            Export PDF
        </a>
    </div>

    <!-- Laporan Table -->
    @if ($bookings->count() > 0)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Studio</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Durasi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Terbayar</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($bookings as $index => $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->jam_mulai }} -
                                        {{ $booking->jam_selesai }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">{{ $booking->studio->nama_studio }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">{{ $booking->durasi_jam }} jam</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $totalBayar = $booking
                                            ->payments()
                                            ->where('status_pembayaran', 'terverifikasi')
                                            ->sum('jumlah_bayar');
                                    @endphp
                                    <p
                                        class="font-semibold {{ $totalBayar >= $booking->total_harga ? 'text-green-600' : 'text-orange-600' }}">
                                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                    </p>
                                    @if ($totalBayar < $booking->total_harga)
                                        <p class="text-xs text-red-600">Kurang: Rp
                                            {{ number_format($booking->total_harga - $totalBayar, 0, ',', '.') }}</p>
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
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right font-bold text-gray-800">Total Pendapatan:</td>
                            <td colspan="3" class="px-6 py-4 font-bold text-2xl text-green-600">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl p-16 text-center shadow-md">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Data</h3>
            <p class="text-gray-500">Tidak ada data laporan untuk ditampilkan</p>
        </div>
    @endif

@endsection
