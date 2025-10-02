@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-8 md:p-12 text-white mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">Selamat Datang, {{ auth()->user()->name }}! 🎵</h1>
                    <p class="text-teal-100 mb-4">Booking studio musik favoritmu dengan mudah dan cepat</p>
                    <a href="{{ route('customer.studio.index') }}"
                        class="inline-block px-6 py-3 bg-white text-teal-600 rounded-lg font-medium hover:bg-teal-50 transition shadow-lg">
                        Lihat Studio Tersedia
                    </a>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6">
                    <div class="text-center">
                        <p class="text-5xl font-bold">{{ $bookingAktif }}</p>
                        <p class="text-teal-200 text-sm mt-2">Booking Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Sistem Booking</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">FCFS</p>
                    </div>
                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Studio</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $studios->count() }}+</p>
                    </div>
                    <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pembayaran</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">QRIS</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Studio Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Studio Populer</h2>
                    <p class="text-gray-500 text-sm">Pilih studio musik terbaik untuk kebutuhanmu</p>
                </div>
                <a href="{{ route('customer.studio.index') }}"
                    class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if ($studios->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($studios as $studio)
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition border border-gray-100">
                            <div
                                class="h-48 bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center">
                                @if ($studio->gambar)
                                    <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                        alt="{{ $studio->nama_studio }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $studio->nama_studio }}</h3>
                                <div class="flex items-center text-gray-500 text-sm mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $studio->lokasi }}
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-2xl font-bold text-purple-600">Rp
                                            {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">per jam</p>
                                    </div>
                                    <a href="{{ route('customer.studio.show', $studio->id) }}"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                        Booking
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center shadow-md">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <p class="text-gray-500">Belum ada studio tersedia</p>
                </div>
            @endif
        </div>

        <!-- Info Section -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-8 border border-indigo-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Cara Booking Studio</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Pilih Studio</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Pilih Tanggal & Jam</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Bayar via QRIS</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold">4</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Datang ke Studio</p>
                </div>
            </div>
        </div>

    </div>
@endsection
