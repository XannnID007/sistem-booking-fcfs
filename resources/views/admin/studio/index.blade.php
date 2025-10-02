@extends('layouts.admin')

@section('title', 'Kelola Studio')
@section('page-title', 'Kelola Studio')
@section('page-subtitle', 'Manajemen data studio musik')

@section('content')

    <!-- Action Bar -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Total: <span class="font-semibold">{{ $studios->total() }}</span> studio</p>
        </div>
        <a href="{{ route('admin.studio.create') }}"
            class="px-5 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg hover:from-teal-700 hover:to-cyan-700 transition font-medium shadow-lg">
            + Tambah Studio
        </a>
    </div>

    <!-- Studio Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if ($studios->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Studio</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Harga/Jam</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($studios as $studio)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-12 h-12 rounded-lg overflow-hidden mr-3 bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center">
                                            @if ($studio->gambar)
                                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                                    alt="{{ $studio->nama_studio }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $studio->nama_studio }}</p>
                                            @if ($studio->deskripsi)
                                                <p class="text-sm text-gray-500">{{ Str::limit($studio->deskripsi, 40) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">{{ Str::limit($studio->lokasi, 35) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($studio->status == 'aktif')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.studio.edit', $studio->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.studio.destroy', $studio->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus studio ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
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

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $studios->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <p class="text-gray-500 mb-4">Belum ada data studio</p>
                <a href="{{ route('admin.studio.create') }}"
                    class="inline-block px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                    + Tambah Studio Pertama
                </a>
            </div>
        @endif
    </div>

@endsection
