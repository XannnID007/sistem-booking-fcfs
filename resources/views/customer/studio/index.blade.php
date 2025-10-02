@extends('layouts.customer')

@section('title', 'Daftar Studio')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Studio Musik</h1>
            <p class="text-gray-600">Pilih studio musik terbaik untuk kebutuhanmu</p>
        </div>

        <!-- Studio Grid -->
        @if ($studios->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($studios as $studio)
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                        <!-- Image -->
                        <div
                            class="h-52 bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center overflow-hidden relative">
                            @if ($studio->gambar)
                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}" alt="{{ $studio->nama_studio }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                    </path>
                                </svg>
                            @endif

                            <!-- Status Badge -->
                            @if ($studio->status == 'aktif')
                                <span
                                    class="absolute top-3 right-3 px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                    Tersedia
                                </span>
                            @else
                                <span
                                    class="absolute top-3 right-3 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $studio->nama_studio }}</h3>

                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ Str::limit($studio->lokasi, 40) }}
                            </div>

                            @if ($studio->deskripsi)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $studio->deskripsi }}</p>
                            @endif

                            <div class="flex items-center justify-between pt-4 border-t">
                                <div>
                                    <p class="text-2xl font-bold text-teal-600">Rp
                                        {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">per jam</p>
                                </div>
                                <a href="{{ route('customer.studio.show', $studio->id) }}"
                                    class="px-5 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg hover:from-teal-700 hover:to-cyan-700 transition-all text-sm font-medium shadow-lg hover:shadow-xl">
                                    Lihat Detail
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
            <!-- Empty State -->
            <div class="bg-white rounded-xl p-16 text-center shadow-md">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Studio</h3>
                <p class="text-gray-500">Saat ini belum ada studio yang tersedia</p>
            </div>
        @endif

    </div>
@endsection
