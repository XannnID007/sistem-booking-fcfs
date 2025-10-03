@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="relative bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-8 overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-yellow-50 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-48 h-48 bg-slate-50 rounded-full"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang Kembali, {{ auth()->user()->name }}!</h1>
                <p class="text-slate-500">Siap untuk membuat musik? Lihat studio yang tersedia atau kelola booking-mu di
                    sini.</p>
                <a href="{{ route('customer.studio.index') }}"
                    class="inline-block mt-6 px-6 py-3 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-all font-bold shadow-lg transform hover:scale-105 text-sm">
                    Booking Studio Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Booking Aktif</p>
                        <p class="text-4xl font-bold text-slate-800 mt-2">{{ $bookingAktif }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('customer.booking.index') }}"
                    class="text-sm font-semibold text-gold-600 hover:underline mt-4 inline-block">Lihat Detail →</a>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Studio</p>
                        <p class="text-4xl font-bold text-slate-800 mt-2">{{ $studios->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-slate-400 mt-4">Pilihan studio berkualitas.</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Riwayat Booking</p>
                        <p class="text-4xl font-bold text-slate-800 mt-2">
                            {{ auth()->user()->bookings()->where('status_booking', 'selesai')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('customer.booking.history') }}"
                    class="text-sm font-semibold text-gold-600 hover:underline mt-4 inline-block">Lihat Riwayat →</a>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-800">Rekomendasi Studio Untukmu</h2>
                <a href="{{ route('customer.studio.index') }}"
                    class="text-sm font-semibold text-gold-600 hover:underline">Lihat Semua</a>
            </div>
            @if ($studios->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($studios->take(3) as $studio)
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 group transform hover:-translate-y-1 transition-transform duration-300">
                            <div class="h-48 bg-slate-200 relative overflow-hidden">
                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                    alt="{{ $studio->nama_studio }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-slate-800 mb-1 truncate">{{ $studio->nama_studio }}</h3>
                                <p class="text-sm text-slate-500 mb-4 line-clamp-1">{{ $studio->lokasi }}</p>
                                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                    <div>
                                        <p class="text-lg font-bold text-gold-600">Rp
                                            {{ number_format($studio->harga_per_jam, 0, ',', '.') }}<span
                                                class="text-sm font-normal text-slate-500">/jam</span></p>
                                    </div>
                                    <a href="{{ route('customer.studio.show', $studio->id) }}"
                                        class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition text-sm font-semibold">Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center border border-slate-200">
                    <p class="text-slate-500">Belum ada studio yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
