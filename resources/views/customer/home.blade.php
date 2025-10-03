@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner - Compact -->
            <div class="relative bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6 overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-amber-50 rounded-full opacity-50"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-slate-50 rounded-full opacity-50"></div>

                <div class="relative z-10">
                    <h1 class="text-2xl font-bold text-slate-900 mb-1">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-sm text-slate-600 mb-4">Siap untuk membuat musik? Mulai booking studio sekarang.</p>
                    <a href="{{ route('customer.studio.index') }}"
                        class="inline-block px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all font-semibold text-sm shadow-sm">
                        Booking Studio
                    </a>
                </div>
            </div>

            <!-- Stats - Compact -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500">Booking Aktif</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $bookingAktif }}</p>
                        </div>
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('customer.booking.index') }}"
                        class="text-xs font-semibold text-amber-600 hover:underline mt-3 inline-block">
                        Lihat Detail →
                    </a>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500">Total Studio</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $studios->count() }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-3">Pilihan berkualitas</p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500">Riwayat</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2">
                                {{ auth()->user()->bookings()->where('status_booking', 'selesai')->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('customer.booking.history') }}"
                        class="text-xs font-semibold text-amber-600 hover:underline mt-3 inline-block">
                        Lihat Riwayat →
                    </a>
                </div>
            </div>

            <!-- Rekomendasi Studio - Compact -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Rekomendasi Studio</h2>
                    <a href="{{ route('customer.studio.index') }}"
                        class="text-sm font-semibold text-amber-600 hover:underline">
                        Lihat Semua
                    </a>
                </div>

                @if ($studios->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach ($studios->take(3) as $studio)
                            <div
                                class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-200">
                                <div class="h-40 bg-slate-100 relative overflow-hidden">
                                    @if ($studio->gambar)
                                        <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                            alt="{{ $studio->nama_studio }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-orange-50">
                                            <svg class="w-12 h-12 text-amber-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3
                                        class="font-bold text-base text-slate-900 mb-1 truncate group-hover:text-amber-600 transition-colors">
                                        {{ $studio->nama_studio }}
                                    </h3>
                                    <p class="text-xs text-slate-600 mb-3 line-clamp-1">{{ $studio->lokasi }}</p>

                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                        <div>
                                            <p class="text-lg font-bold text-amber-600">
                                                Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-slate-500">per jam</p>
                                        </div>
                                        <a href="{{ route('customer.studio.show', $studio->id) }}"
                                            class="px-4 py-2 bg-slate-900 text-white text-sm rounded-lg hover:bg-amber-600 transition-colors font-medium">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl p-12 text-center border border-slate-200">
                        <p class="text-sm text-slate-500">Belum ada studio yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
