@extends('layouts.customer')

@section('title', 'Detail Studio')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <a href="{{ route('customer.studio.index') }}"
            class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Studio
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Studio Info -->
            <div class="lg:col-span-2">
                <!-- Image -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg mb-6">
                    <div class="h-96 bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center">
                        @if ($studio->gambar)
                            <img src="{{ asset('uploads/studios/' . $studio->gambar) }}" alt="{{ $studio->nama_studio }}"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                </path>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Details -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $studio->nama_studio }}</h1>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                                Tersedia
                            </span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $studio->deskripsi ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>

                    <div class="border-t mt-6 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Harga</h3>
                        <div class="flex items-end">
                            <span class="text-4xl font-bold text-teal-600">Rp
                                {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</span>
                            <span class="text-gray-500 ml-2 mb-1">per jam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Booking Studio</h3>

                    @if ($studio->status == 'aktif')
                        <div class="space-y-4">
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                                <p class="text-sm text-teal-700 mb-2">💡 <strong>Info Booking</strong></p>
                                <ul class="text-xs text-teal-600 space-y-1">
                                    <li>✓ Sistem FCFS (First Come First Served)</li>
                                    <li>✓ Cek ketersediaan jadwal real-time</li>
                                    <li>✓ Pembayaran fleksibel (DP/Lunas)</li>
                                </ul>
                            </div>

                            <a href="{{ route('customer.booking.create', $studio->id) }}"
                                class="block w-full text-center bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-4 rounded-lg font-bold hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                                🎵 Booking Sekarang
                            </a>

                            <div class="text-center">
                                <p class="text-xs text-gray-500">Dengan booking, Anda menyetujui</p>
                                <a href="#" class="text-xs text-teal-600 hover:underline">Syarat & Ketentuan</a>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <p class="text-red-700 font-medium">Studio Tidak Tersedia</p>
                            <p class="text-red-600 text-sm mt-1">Studio ini sedang tidak aktif</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
