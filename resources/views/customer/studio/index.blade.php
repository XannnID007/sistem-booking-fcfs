@extends('layouts.customer')

@section('title', 'Daftar Studio')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight">Temukan Studio Impianmu</h1>
            <p class="mt-2 text-lg text-slate-500 max-w-2xl mx-auto">Pilih dari berbagai studio musik profesional yang siap
                mendukung karyamu.</p>
        </div>

        @if ($studios->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($studios as $studio)
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 group transform hover:-translate-y-1 transition-transform duration-300">
                        <div class="h-52 bg-slate-200 relative overflow-hidden">
                            @if ($studio->gambar)
                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}" alt="{{ $studio->nama_studio }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-50 to-amber-100">
                                    <svg class="w-16 h-16 text-yellow-400 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">...</svg>
                                </div>
                            @endif

                            @if ($studio->status == 'aktif')
                                <span
                                    class="absolute top-3 right-3 px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full border border-green-200">Tersedia</span>
                            @else
                                <span
                                    class="absolute top-3 right-3 px-2.5 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full border border-red-200">Tutup</span>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-lg text-slate-800 mb-1 truncate">{{ $studio->nama_studio }}</h3>
                            <p class="text-sm text-slate-500 mb-4 line-clamp-1 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">...</svg>
                                {{ Str::limit($studio->lokasi, 40) }}
                            </p>

                            <p class="text-xs text-slate-600 h-16 line-clamp-3">
                                {{ $studio->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100">
                                <div>
                                    <p class="text-lg font-bold text-gold-600">Rp
                                        {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500 font-medium">/ jam</p>
                                </div>
                                <a href="{{ route('customer.studio.show', $studio->id) }}"
                                    class="px-5 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition text-sm font-semibold">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $studios->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl p-16 text-center border border-slate-200">
                <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">...</svg>
                <h3 class="text-xl font-semibold text-slate-800 mb-1">Oops! Studio Belum Tersedia</h3>
                <p class="text-slate-500">Saat ini belum ada studio yang bisa di-booking. Silakan cek kembali nanti.</p>
            </div>
        @endif
    </div>
@endsection
