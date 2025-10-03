@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('page-subtitle', 'Informasi lengkap untuk booking #' . $booking->id)

@section('content')

    <a href="{{ route('admin.booking.index') }}"
        class="inline-flex items-center text-amber-600 hover:underline mb-6 font-semibold text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Data Booking
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                    <h2 class="text-lg font-semibold text-slate-800">Informasi Booking</h2>
                    @if ($booking->status_booking == 'pending')
                        <span
                            class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-xs">Pending</span>
                    @elseif($booking->status_booking == 'dibayar')
                        <span
                            class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold text-xs">Dibayar</span>
                    @elseif($booking->status_booking == 'selesai')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs">Selesai</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold text-xs">Dibatalkan</span>
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Customer</h4>
                        <p class="font-medium text-slate-700">{{ $booking->user->name }}</p>
                        <p class="text-slate-500">{{ $booking->user->email }}</p>
                        <p class="text-slate-500">{{ $booking->user->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Studio</h4>
                        <p class="font-medium text-slate-700">{{ $booking->studio->nama_studio }}</p>
                        <p class="text-slate-500">{{ $booking->studio->lokasi }}</p>
                    </div>
                    <div class="md:col-span-2 border-t border-slate-100 pt-4">
                        <h4 class="font-semibold text-slate-800 mb-2">Jadwal</h4>
                        <div class="flex justify-between">
                            <p class="text-slate-500">Tanggal:</p>
                            <p class="font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-slate-500">Waktu:</p>
                            <p class="font-medium text-slate-700">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                ({{ $booking->durasi_jam }} jam)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Riwayat Pembayaran</h3>
                @if ($booking->payments->count() > 0)
                    <ul class="space-y-4">
                        @foreach ($booking->payments as $payment)
                            <li class="border border-slate-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-slate-800 text-lg">Rp
                                            {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                            - {{ strtoupper($payment->metode_pembayaran) }}</p>
                                    </div>
                                    @if ($payment->status_pembayaran == 'pending')
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Pending</span>
                                    @elseif ($payment->status_pembayaran == 'terverifikasi')
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Terverifikasi</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Ditolak</span>
                                    @endif
                                </div>
                                <a href="{{ asset('uploads/payments/' . $payment->bukti_transfer) }}" target="_blank"
                                    class="text-sm font-semibold text-amber-600 hover:underline">Lihat Bukti Transfer</a>
                                @if ($payment->catatan_admin)
                                    <div class="mt-2 p-2 bg-slate-50 rounded text-xs text-slate-600"><strong>Catatan
                                            Admin:</strong> {{ $payment->catatan_admin }}</div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-slate-500 text-center py-8 text-sm">Belum ada riwayat pembayaran untuk booking ini.</p>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Status Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-600">Total Harga:</span><span
                                class="font-semibold text-slate-800">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">Total Terbayar:</span><span
                                class="font-semibold text-green-600">Rp
                                {{ number_format($totalBayar, 0, ',', '.') }}</span></div>
                    </div>
                    <div class="border-t border-slate-100 mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800">Sisa Bayar:</span>
                            <span class="font-bold text-xl {{ $sisaBayar > 0 ? 'text-red-600' : 'text-green-600' }}">Rp
                                {{ number_format($sisaBayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Admin</h3>
                    <div class="space-y-3">
                        @if ($booking->status_booking == 'dibayar')
                            <form action="{{ route('admin.booking.complete', $booking->id) }}" method="POST"
                                onsubmit="return confirm('Tandai booking ini sebagai SELESAI?')">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                    Tandai Selesai
                                </button>
                            </form>
                        @endif

                        @if ($sisaBayar > 0 && $booking->status_booking != 'dibatalkan')
                            <form action="{{ route('admin.payment.pelunasan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <div class="space-y-3 p-4 bg-slate-50 rounded-lg border border-slate-200">
                                    <h4 class="font-semibold text-slate-700 text-sm">Input Pelunasan Cash</h4>
                                    <div>
                                        <label class="block text-slate-600 text-xs font-medium mb-1">Jumlah</label>
                                        <input type="number" name="jumlah_bayar" required min="1"
                                            max="{{ $sisaBayar }}"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm"
                                            placeholder="Rp {{ number_format($sisaBayar, 0, ',', '.') }}">
                                    </div>
                                    <div>
                                        <label class="block text-slate-600 text-xs font-medium mb-1">Catatan</label>
                                        <textarea name="catatan_admin" rows="2"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm"
                                            placeholder="Opsional"></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                                        Simpan Pelunasan
                                    </button>
                                </div>
                            </form>
                        @endif

                        <a href="{{ route('admin.booking.index') }}"
                            class="block w-full px-4 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-center font-medium text-sm">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
