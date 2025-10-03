@extends('layouts.admin')

@section('title', 'Detail Studio')
@section('page-title', 'Detail Studio')
@section('page-subtitle', 'Informasi lengkap untuk ' . $studio->nama_studio)

@section('content')
    <a href="{{ route('admin.studio.index') }}"
        class="inline-flex items-center text-amber-600 hover:underline mb-6 font-semibold text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Studio
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <div class="flex flex-col md:flex-row md:items-start gap-6">
                    <div class="w-full md:w-48 h-48 flex-shrink-0 bg-slate-200 rounded-lg overflow-hidden">
                        @if ($studio->gambar)
                            <img src="{{ asset('uploads/studios/' . $studio->gambar) }}" alt="{{ $studio->nama_studio }}"
                                class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-yellow-200">
                                ...</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h1 class="text-2xl font-bold text-slate-800">{{ $studio->nama_studio }}</h1>
                            @if ($studio->status == 'aktif')
                                <span
                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">Aktif</span>@else<span
                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold border border-red-200">Nonaktif</span>
                            @endif
                        </div>
                        <p class="text-slate-500 mt-2">{{ $studio->lokasi }}</p>
                        <p class="text-2xl font-bold text-amber-600 mt-4">Rp
                            {{ number_format($studio->harga_per_jam, 0, ',', '.') }}<span
                                class="text-sm font-medium text-slate-500">/jam</span></p>
                    </div>
                </div>
                <div class="border-t border-slate-100 pt-4 mt-4">
                    <h3 class="font-semibold text-slate-800 mb-2">Deskripsi</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $studio->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Booking Terbaru</h3>
                @if ($studio->bookings()->count() > 0)
                    <ul class="space-y-4">
                        @foreach ($studio->bookings()->with('user')->latest()->take(5)->get() as $booking)
                            <li class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                                    <p class="font-bold text-slate-600">{{ substr($booking->user->name, 0, 1) }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-slate-800">{{ $booking->user->name }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-slate-500 text-sm text-center py-8">Belum ada booking untuk studio ini.</p>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Statistik</h3>
                @php
                    $totalPendapatan = $studio->bookings()->where('status_booking', 'selesai')->sum('total_harga');
                @endphp
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-slate-600">Total Booking:</p>
                        <p class="font-bold text-slate-800">{{ $studio->bookings()->count() }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-slate-600">Booking Selesai:</p>
                        <p class="font-bold text-slate-800">
                            {{ $studio->bookings()->where('status_booking', 'selesai')->count() }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-slate-600">Total Pendapatan:</p>
                        <p class="font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.studio.edit', $studio->id) }}"
                        class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">Edit
                        Studio</a>
                    <form action="{{ route('admin.studio.destroy', $studio->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus studio ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">Hapus
                            Studio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
