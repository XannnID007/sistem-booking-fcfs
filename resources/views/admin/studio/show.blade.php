@extends('layouts.admin')

@section('title', 'Detail Studio')
@section('page-title', 'Detail Studio')
@section('page-subtitle', 'Informasi lengkap studio')

@section('content')

    <div class="max-w-5xl">
        <!-- Back Button -->
        <a href="{{ route('admin.studio.index') }}"
            class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Studio
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Studio Info -->
            <div class="lg:col-span-2">
                <!-- Image -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md mb-6">
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
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $studio->nama_studio }}</h1>
                            <div class="flex items-center text-gray-600 mb-2">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor"
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
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                                Aktif
                            </span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi Studio</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $studio->deskripsi ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>

                    <div class="border-t mt-6 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Harga</h3>
                        <div class="bg-teal-50 rounded-lg p-6">
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm mb-1">Harga per Jam</p>
                                    <span class="text-4xl font-bold text-teal-600">Rp
                                        {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</span>
                                </div>
                                <svg class="w-16 h-16 text-teal-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="border-t mt-6 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Tambahan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Dibuat</p>
                                <p class="font-medium text-gray-800">{{ $studio->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Update Terakhir</p>
                                <p class="font-medium text-gray-800">{{ $studio->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats & Actions -->
            <div class="lg:col-span-1">
                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Booking</h3>

                    @php
                        $totalBooking = $studio->bookings()->count();
                        $bookingSelesai = $studio->bookings()->where('status_booking', 'selesai')->count();
                        $bookingAktif = $studio
                            ->bookings()
                            ->whereIn('status_booking', ['pending', 'dibayar'])
                            ->count();
                        $totalPendapatan = $studio->bookings()->where('status_booking', 'selesai')->sum('total_harga');
                    @endphp

                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4">
                            <p class="text-sm text-blue-600 mb-1">Total Booking</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $totalBooking }}</p>
                        </div>

                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4">
                            <p class="text-sm text-green-600 mb-1">Booking Selesai</p>
                            <p class="text-3xl font-bold text-green-700">{{ $bookingSelesai }}</p>
                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                            <p class="text-sm text-orange-600 mb-1">Booking Aktif</p>
                            <p class="text-3xl font-bold text-orange-700">{{ $bookingAktif }}</p>
                        </div>

                        <div class="bg-gradient-to-r from-teal-50 to-teal-100 rounded-lg p-4">
                            <p class="text-sm text-teal-600 mb-1">Total Pendapatan</p>
                            <p class="text-xl font-bold text-teal-700">Rp
                                {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>

                    <div class="space-y-3">
                        <a href="{{ route('admin.studio.edit', $studio->id) }}"
                            class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Studio
                        </a>

                        <form action="{{ route('admin.studio.destroy', $studio->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus studio ini? Semua data booking terkait akan hilang!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus Studio
                            </button>
                        </form>

                        <a href="{{ route('admin.studio.index') }}"
                            class="block w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center font-medium">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        @if ($studio->bookings()->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Booking Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($studio->bookings()->with('user')->latest()->take(10)->get() as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-800">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $booking->durasi_jam }} jam</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800">Rp
                                            {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($booking->status_booking == 'pending')
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                        @elseif($booking->status_booking == 'dibayar')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Dibayar</span>
                                        @elseif($booking->status_booking == 'selesai')
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Selesai</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

@endsection
