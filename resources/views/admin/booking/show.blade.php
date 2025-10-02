@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('page-subtitle', 'Informasi lengkap booking')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Booking Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Info -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Informasi Booking</h3>
                    @if ($booking->status_booking == 'pending')
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold">Pending</span>
                    @elseif($booking->status_booking == 'dibayar')
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold">Dibayar</span>
                    @elseif($booking->status_booking == 'selesai')
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold">Selesai</span>
                    @else
                        <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold">Dibatalkan</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Info -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Data Customer</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-800">{{ $booking->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">No. Telepon</p>
                                <p class="text-gray-800">{{ $booking->user->no_telepon ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Studio Info -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Data Studio</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Nama Studio</p>
                                <p class="font-medium text-gray-800">{{ $booking->studio->nama_studio }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="text-gray-800">{{ $booking->studio->lokasi }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Harga per Jam</p>
                                <p class="text-gray-800">Rp
                                    {{ number_format($booking->studio->harga_per_jam, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t mt-6 pt-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Detail Waktu</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jam</p>
                            <p class="font-medium text-gray-800">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Durasi</p>
                            <p class="font-medium text-gray-800">{{ $booking->durasi_jam }} Jam</p>
                        </div>
                    </div>
                </div>

                @if ($booking->catatan)
                    <div class="border-t mt-6 pt-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Catatan Customer</h4>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $booking->catatan }}</p>
                    </div>
                @endif

                <div class="border-t mt-6 pt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total Harga:</span>
                        <span class="text-3xl font-bold text-teal-600">Rp
                            {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pembayaran</h3>

                @if ($booking->payments->count() > 0)
                    <div class="space-y-4">
                        @foreach ($booking->payments as $payment)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-lg">Rp
                                            {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}
                                            - {{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $payment->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    @if ($payment->status_pembayaran == 'pending')
                                        <span
                                            class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($payment->status_pembayaran == 'terverifikasi')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Terverifikasi</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Ditolak</span>
                                    @endif
                                </div>

                                @if ($payment->bukti_transfer)
                                    <div class="mb-3">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Bukti Transfer:</p>
                                        <img src="{{ asset('uploads/payments/' . $payment->bukti_transfer) }}"
                                            alt="Bukti Transfer"
                                            class="w-48 h-48 object-cover rounded-lg border cursor-pointer hover:opacity-75"
                                            onclick="window.open(this.src, '_blank')">
                                    </div>
                                @endif

                                @if ($payment->catatan_admin)
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-700"><strong>Catatan Admin:</strong>
                                            {{ $payment->catatan_admin }}</p>
                                    </div>
                                @endif

                                @if ($payment->verifikator)
                                    <p class="text-xs text-gray-500 mt-2">Diverifikasi oleh:
                                        {{ $payment->verifikator->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Total Harga:</span>
                            <span class="font-bold text-gray-800">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Total Terbayar:</span>
                            <span class="font-bold text-green-600">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t">
                            <span class="text-gray-700 font-semibold">Sisa Pembayaran:</span>
                            <span class="font-bold {{ $sisaBayar > 0 ? 'text-red-600' : 'text-green-600' }}">
                                Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Belum ada pembayaran</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-20 space-y-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>

                @if ($booking->status_booking == 'dibayar')
                    <form action="{{ route('admin.booking.complete', $booking->id) }}" method="POST"
                        onsubmit="return confirm('Tandai booking ini sebagai selesai?')">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            ✓ Tandai Selesai
                        </button>
                    </form>
                @endif

                @php
                    $totalBayar = $booking
                        ->payments()
                        ->where('status_pembayaran', 'terverifikasi')
                        ->sum('jumlah_bayar');
                    $sisaBayar = $booking->total_harga - $totalBayar;
                @endphp

                @if ($sisaBayar > 0 && $booking->status_booking != 'dibatalkan')
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Input Pelunasan Cash</h4>

                        <!-- Info Sisa Pembayaran -->
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Total Harga:</span>
                                <span class="font-medium">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Sudah Dibayar:</span>
                                <span class="font-medium text-green-600">Rp
                                    {{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-orange-300 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-800">Sisa:</span>
                                    <span class="font-bold text-orange-600">Rp
                                        {{ number_format($sisaBayar, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.payment.pelunasan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Jumlah</label>
                                <input type="number" name="jumlah_bayar" required min="1"
                                    max="{{ $sisaBayar }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    placeholder="{{ number_format($sisaBayar, 0, ',', '.') }}">
                                <p class="text-xs text-gray-500 mt-1">Maksimal: Rp
                                    {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Catatan</label>
                                <textarea name="catatan_admin" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    placeholder="Catatan pelunasan..."></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                Simpan Pelunasan
                            </button>
                        </form>
                    </div>
                @endif

                <a href="{{ route('admin.booking.index') }}"
                    class="block w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center font-medium">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

@endsection
