@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')
@section('page-subtitle', 'Kelola dan verifikasi pembayaran')

@section('content')

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form action="{{ route('admin.payment.index') }}" method="GET" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-gray-700 text-sm font-medium mb-2">Status Pembayaran</label>
                <select name="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi
                    </option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <button type="submit"
                class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                Filter
            </button>
            <a href="{{ route('admin.payment.index') }}"
                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm">Menunggu Verifikasi</p>
            <p class="text-2xl font-bold text-gray-800">{{ $payments->where('status_pembayaran', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Terverifikasi</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $payments->where('status_pembayaran', 'terverifikasi')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-red-500">
            <p class="text-gray-600 text-sm">Ditolak</p>
            <p class="text-2xl font-bold text-gray-800">{{ $payments->where('status_pembayaran', 'ditolak')->count() }}</p>
        </div>
    </div>

    <!-- Payment List -->
    @if ($payments->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($payments as $payment)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white font-bold">{{ $payment->booking->user->name }}</p>
                                <p class="text-teal-100 text-sm">{{ $payment->booking->studio->nama_studio }}</p>
                            </div>
                            @if ($payment->status_pembayaran == 'pending')
                                <span
                                    class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                            @elseif($payment->status_pembayaran == 'terverifikasi')
                                <span
                                    class="px-3 py-1 bg-green-400 text-green-900 rounded-full text-xs font-semibold">Terverifikasi</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-red-400 text-red-900 rounded-full text-xs font-semibold">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Payment Info -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Jumlah Bayar:</span>
                                <span class="text-2xl font-bold text-teal-600">Rp
                                    {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Tipe:</span>
                                <span
                                    class="font-medium">{{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ($payment->tipe_pembayaran == 'lunas' ? 'Lunas' : 'Pelunasan') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Metode:</span>
                                <span
                                    class="font-medium">{{ $payment->metode_pembayaran == 'qris' ? 'QRIS' : 'Cash' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Waktu Upload:</span>
                                <span class="font-medium">{{ $payment->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>

                        <!-- Booking Info -->
                        <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm">
                            <p class="text-gray-600 mb-1">Detail Booking:</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($payment->booking->tanggal_booking)->format('d M Y') }} |
                                {{ $payment->booking->jam_mulai }} - {{ $payment->booking->jam_selesai }}</p>
                            <p class="text-gray-600">Total: Rp
                                {{ number_format($payment->booking->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <!-- Bukti Transfer -->
                        @if ($payment->bukti_transfer && $payment->metode_pembayaran == 'qris')
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Bukti Transfer:</p>
                                <img src="{{ asset('uploads/payments/' . $payment->bukti_transfer) }}" alt="Bukti Transfer"
                                    class="w-full h-64 object-contain rounded-lg border cursor-pointer hover:opacity-75"
                                    onclick="window.open(this.src, '_blank')">
                                <p class="text-xs text-gray-500 mt-1 text-center">Klik untuk memperbesar</p>
                            </div>
                        @endif

                        <!-- Catatan Admin (jika ada) -->
                        @if ($payment->catatan_admin)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <p class="text-sm text-blue-700"><strong>Catatan:</strong> {{ $payment->catatan_admin }}
                                </p>
                            </div>
                        @endif

                        <!-- Actions -->
                        @if ($payment->status_pembayaran == 'pending')
                            <div class="flex gap-3">
                                <!-- Verifikasi -->
                                <button onclick="openVerifyModal({{ $payment->id }})"
                                    class="flex-1 bg-green-600 text-white py-2.5 rounded-lg hover:bg-green-700 transition font-medium">
                                    ✓ Verifikasi
                                </button>
                                <!-- Tolak -->
                                <button onclick="openRejectModal({{ $payment->id }})"
                                    class="flex-1 bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 transition font-medium">
                                    ✗ Tolak
                                </button>
                            </div>
                        @else
                            <div class="text-center py-2">
                                @if ($payment->verifikator)
                                    <p class="text-sm text-gray-600">Diproses oleh: <span
                                            class="font-medium">{{ $payment->verifikator->name }}</span></p>
                                    <p class="text-xs text-gray-500">
                                        {{ $payment->tanggal_verifikasi ? $payment->tanggal_verifikasi->format('d M Y H:i') : '-' }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl p-16 text-center shadow-md">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Pembayaran</h3>
            <p class="text-gray-500">Belum ada pembayaran yang perlu diverifikasi</p>
        </div>
    @endif

    <!-- Modal Verifikasi -->
    <div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Verifikasi Pembayaran</h3>
            <form id="verifyForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan_admin" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-green-600 text-white py-2.5 rounded-lg hover:bg-green-700 transition font-medium">
                        Verifikasi
                    </button>
                    <button type="button" onclick="closeVerifyModal()"
                        class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg hover:bg-gray-200 transition font-medium">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tolak Pembayaran</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Alasan Penolakan <span
                            class="text-red-500">*</span></label>
                    <textarea name="catatan_admin" rows="4" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 transition font-medium">
                        Tolak
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg hover:bg-gray-200 transition font-medium">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openVerifyModal(paymentId) {
                const form = document.getElementById('verifyForm');
                form.action = `/admin/pembayaran/${paymentId}/verifikasi`;
                document.getElementById('verifyModal').classList.remove('hidden');
            }

            function closeVerifyModal() {
                document.getElementById('verifyModal').classList.add('hidden');
            }

            function openRejectModal(paymentId) {
                const form = document.getElementById('rejectForm');
                form.action = `/admin/pembayaran/${paymentId}/tolak`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            document.getElementById('verifyModal').addEventListener('click', function(e) {
                if (e.target === this) closeVerifyModal();
            });

            document.getElementById('rejectModal').addEventListener('click', function(e) {
                if (e.target === this) closeRejectModal();
            });
        </script>
    @endpush

@endsection
