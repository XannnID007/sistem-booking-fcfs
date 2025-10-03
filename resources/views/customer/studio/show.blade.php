@extends('layouts.customer')

@section('title', 'Detail Studio')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('customer.studio.index') }}"
                class="inline-flex items-center text-sm text-amber-600 hover:text-amber-700 mb-6 font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm mb-6">
                        <div class="h-64 bg-slate-100">
                            @if ($studio->gambar)
                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                    alt="{{ $studio->nama_studio }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-orange-50">
                                    <svg class="w-20 h-20 text-amber-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $studio->nama_studio }}</h1>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="w-4 h-4 mr-1 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $studio->lokasi }}
                                </div>
                            </div>
                            @if ($studio->status == 'aktif')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                    Tutup
                                </span>
                            @endif
                        </div>

                        <div class="border-t pt-4 mb-4">
                            <h3 class="text-sm font-bold text-slate-900 mb-2">Deskripsi</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $studio->deskripsi ?? 'Studio musik profesional dengan fasilitas lengkap.' }}
                            </p>
                        </div>

                        <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                            <p class="text-xs text-slate-600 mb-1">Harga Sewa</p>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-amber-600">
                                    Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-slate-600 ml-2">/ jam</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-5 sticky top-20">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Booking Studio</h3>

                        @if ($studio->status == 'aktif')
                            <div class="bg-blue-50 rounded-lg p-4 mb-4 border border-blue-200">
                                <p class="text-xs font-bold text-blue-900 mb-2">Info Booking</p>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li class="flex items-start">
                                        <svg class="w-3.5 h-3.5 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>First Come First Served</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-3.5 h-3.5 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Cek ketersediaan real-time</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-3.5 h-3.5 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Pembayaran DP/Lunas</span>
                                    </li>
                                </ul>
                            </div>

                            <a href="{{ route('customer.booking.create', $studio->id) }}"
                                class="block w-full text-center bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors text-sm shadow-sm">
                                Booking Sekarang
                            </a>

                            <p class="text-xs text-center text-slate-500 mt-3">
                                Dengan booking, Anda menyetujui <a href="#"
                                    class="text-amber-600 hover:underline">S&K</a>
                            </p>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <p class="text-sm font-bold text-red-800">Tidak Tersedia</p>
                                <p class="text-xs text-red-600 mt-1">Studio sedang tutup</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
