@extends('layouts.customer')

@section('title', 'Daftar Studio')

@section('content')
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Compact Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Studio Musik</h1>
                <p class="text-sm text-slate-600 mt-1">Pilih studio terbaik untuk kebutuhan Anda</p>
            </div>

            @if ($studios->count() > 0)
                <!-- Compact Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($studios as $studio)
                        <div
                            class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-200">
                            <!-- Compact Image -->
                            <div class="relative h-40 overflow-hidden bg-slate-100">
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

                                <!-- Status Badge - Compact -->
                                @if ($studio->status == 'aktif')
                                    <span
                                        class="absolute top-2 right-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-md shadow">
                                        Tersedia
                                    </span>
                                @else
                                    <span
                                        class="absolute top-2 right-2 px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded-md shadow">
                                        Tutup
                                    </span>
                                @endif
                            </div>

                            <!-- Compact Content -->
                            <div class="p-4">
                                <h3
                                    class="font-bold text-base text-slate-900 mb-1 truncate group-hover:text-amber-600 transition-colors">
                                    {{ $studio->nama_studio }}
                                </h3>

                                <div class="flex items-center text-xs text-slate-500 mb-3">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate">{{ Str::limit($studio->lokasi, 30) }}</span>
                                </div>

                                <!-- Compact Price & Button -->
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

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $studios->links() }}
                </div>
            @else
                <!-- Compact Empty State -->
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Studio</h3>
                    <p class="text-sm text-slate-500">Saat ini belum ada studio yang tersedia</p>
                </div>
            @endif
        </div>
    </div>
@endsection
