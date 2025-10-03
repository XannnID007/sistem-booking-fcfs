@extends('layouts.admin')

@section('title', 'Kelola Studio')
@section('page-title', 'Kelola Studio')
@section('page-subtitle', 'Manajemen data studio musik')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-slate-500 text-sm">Total <span class="font-semibold text-slate-700">{{ $studios->total() }}</span>
                studio ditemukan.</p>
        </div>
        <a href="{{ route('admin.studio.create') }}"
            class="px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold text-sm shadow-md flex items-center">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Studio Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        @if ($studios->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Studio</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Lokasi</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Harga/Jam</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Status</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($studios as $studio)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden mr-4 flex-shrink-0 bg-slate-200">
                                            @if ($studio->gambar)
                                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                                    alt="{{ $studio->nama_studio }}"
                                                class="w-full h-full object-cover">@else<div
                                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-yellow-200">
                                                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $studio->nama_studio }}</p>
                                            <p class="text-xs text-slate-500">{{ Str::limit($studio->deskripsi, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ Str::limit($studio->lokasi, 35) }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">Rp
                                    {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if ($studio->status == 'aktif')
                                        <span
                                        class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">Aktif</span>@else<span
                                            class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold border border-red-200">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.studio.show', $studio->id) }}"
                                            class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition"
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.studio.edit', $studio->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.studio.destroy', $studio->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus studio ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-100 rounded-full transition"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50">
                {{ $studios->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <p class="text-slate-500 mb-4">Belum ada data studio yang ditambahkan.</p>
                <a href="{{ route('admin.studio.create') }}"
                    class="inline-block px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-medium">
                    + Tambah Studio Pertama
                </a>
            </div>
        @endif
    </div>

@endsection
