@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Analisis pendapatan dan data booking')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Filter Laporan</h3>
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2">Status</label>
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
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="w-full px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold text-sm">Terapkan
                            Filter</button>
                        <a href="{{ route('admin.laporan.index') }}"
                            class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition"
                            title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path>
                            </svg>
                        </a>
                    </div>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Export Laporan</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.laporan.excel') }}?{{ http_build_query(request()->all()) }}"
                        class="w-full flex items-center justify-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg> Excel
                    </a>
                    <a href="{{ route('admin.laporan.pdf') }}?{{ http_build_query(request()->all()) }}"
                        class="w-full flex items-center justify-center px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg> PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-amber-500 to-yellow-500 rounded-xl p-6 shadow-lg text-white">
                    <p class="font-medium opacity-80">Total Pendapatan</p>
                    <p class="text-4xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <p class="text-sm opacity-70 mt-1">dari {{ $bookings->where('status_booking', 'selesai')->count() }}
                        booking selesai</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Total Booking</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $bookings->total() }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Pending</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">
                            {{ $bookings->where('status_booking', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            @if ($bookings->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">No</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Tanggal</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Customer</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Studio</th>
                                    <th class="px-6 py-3 text-right font-semibold text-slate-600">Total Harga</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($bookings as $index => $booking)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 text-slate-600">{{ $bookings->firstItem() + $index }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-slate-800">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                            <p class="text-xs text-slate-500">{{ $booking->jam_mulai }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-slate-800">{{ $booking->user->name }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-slate-600">{{ $booking->studio->nama_studio }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-right font-semibold text-slate-800">Rp
                                            {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($booking->status_booking == 'pending')
                                                <span
                                                    class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                                            @elseif($booking->status_booking == 'dibayar')
                                                <span
                                                    class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Dibayar</span>
                                            @elseif($booking->status_booking == 'selesai')
                                                <span
                                                    class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Selesai</span>
                                            @else<span
                                                    class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-slate-50">{{ $bookings->appends(request()->query())->links() }}</div>
                </div>
            @else
                <div class="bg-white rounded-xl p-16 text-center shadow-sm border border-slate-200">
                    <h3 class="text-xl font-semibold text-slate-800 mb-1">Tidak Ada Data Ditemukan</h3>
                    <p class="text-slate-500">Coba ubah atau reset filter pencarian Anda.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
