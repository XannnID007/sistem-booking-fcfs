@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Analisis pendapatan dan data booking')

@section('content')

    <!-- Filter & Export Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
        <!-- Filter Card -->
        <div class="lg:col-span-3 bg-white rounded-xl shadow-sm p-5 border border-slate-200">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div class="flex-1">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Tanggal Akhir</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div class="flex-1">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Status Booking</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="">🔍 Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>💰 Dibayar</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm shadow-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition"
                        title="Reset">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Export Card -->
        <div
            class="lg:col-span-1 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-sm p-5 border border-green-200">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-bold text-green-800 text-sm">Export</h3>
            </div>

            <div class="space-y-2">
                <a href="{{ route('admin.laporan.excel') }}?{{ http_build_query(request()->all()) }}"
                    class="flex items-center justify-center w-full px-3 py-2 bg-white border border-green-300 text-green-700 rounded-lg hover:bg-green-50 transition font-semibold text-xs shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Excel
                </a>

                <a href="{{ route('admin.laporan.pdf') }}?{{ http_build_query(request()->all()) }}"
                    class="flex items-center justify-center w-full px-3 py-2 bg-white border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition font-semibold text-xs shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Revenue Card & Stats -->
    <div class="space-y-6">
        <!-- Revenue Card -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl shadow-xl p-6 text-white">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-amber-100">Total Pendapatan</h3>
                    </div>
                    <p class="text-4xl font-bold mb-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <p class="text-sm text-amber-100">
                        Dari {{ $bookings->where('status_booking', 'selesai')->count() }} booking selesai
                    </p>
                </div>
                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200">
                <p class="text-xs text-slate-500 mb-1">Total Booking</p>
                <p class="text-2xl font-bold text-slate-800">{{ $bookings->total() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-yellow-200">
                <p class="text-xs text-slate-500 mb-1">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $bookings->where('status_booking', 'pending')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-green-200">
                <p class="text-xs text-slate-500 mb-1">Dibayar</p>
                <p class="text-2xl font-bold text-green-600">{{ $bookings->where('status_booking', 'dibayar')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-200">
                <p class="text-xs text-slate-500 mb-1">Selesai</p>
                <p class="text-2xl font-bold text-blue-600">{{ $bookings->where('status_booking', 'selesai')->count() }}
                </p>
            </div>
        </div>

        <!-- Data Table -->
        @if ($bookings->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Studio</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700">Durasi</th>
                                <th class="px-4 py-3 text-right text-xs font-bold text-slate-700">Total Harga</th>
                                <th class="px-4 py-3 text-right text-xs font-bold text-slate-700">Terbayar</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-slate-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($bookings as $index => $booking)
                                @php
                                    $totalBayar = $booking
                                        ->payments()
                                        ->where('status_pembayaran', 'terverifikasi')
                                        ->sum('jumlah_bayar');
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 text-slate-600 font-medium">{{ $bookings->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $booking->jam_mulai }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-800">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-slate-700">{{ $booking->studio->nama_studio }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold">
                                            {{ $booking->durasi_jam }} jam
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-slate-800">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-green-600">
                                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($booking->status_booking == 'pending')
                                            <span
                                                class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                                                Pending
                                            </span>
                                        @elseif($booking->status_booking == 'dibayar')
                                            <span
                                                class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                Dibayar
                                            </span>
                                        @elseif($booking->status_booking == 'selesai')
                                            <span
                                                class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak Ada Data</h3>
                <p class="text-sm text-slate-500 mb-4">Tidak ada data booking untuk periode yang dipilih.</p>
                <a href="{{ route('admin.laporan.index') }}"
                    class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                    Reset Filter
                </a>
            </div>
        @endif
    </div>
    </div>

@endsection
