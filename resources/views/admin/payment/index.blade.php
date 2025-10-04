@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')
@section('page-subtitle', 'Kelola dan verifikasi pembayaran dari customer')

@section('content')

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-200 mb-6">
        <form action="{{ route('admin.payment.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-slate-700 text-xs font-bold mb-2">Status Pembayaran</label>
                <select name="status"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                    <option value="">🔍 Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi
                    </option>
                    <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>✅
                        Terverifikasi</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold text-sm shadow-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.payment.index') }}"
                    class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition"
                    title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <!-- Pending Card -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-5 border border-yellow-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center border border-yellow-300">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-bold">Pending</span>
            </div>
            <p class="text-3xl font-bold text-yellow-700 mb-1">
                {{ $payments->where('status_pembayaran', 'pending')->count() }}
            </p>
            <p class="text-xs text-yellow-600">Menunggu Verifikasi</p>
        </div>

        <!-- Terverifikasi Card -->
        <div
            class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center border border-green-300">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-green-200 text-green-800 rounded-full text-xs font-bold">Verified</span>
            </div>
            <p class="text-3xl font-bold text-green-700 mb-1">
                {{ $payments->where('status_pembayaran', 'terverifikasi')->count() }}
            </p>
            <p class="text-xs text-green-600">Berhasil Diverifikasi</p>
        </div>

        <!-- Ditolak Card -->
        <div
            class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl p-5 border border-red-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center border border-red-300">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-red-200 text-red-800 rounded-full text-xs font-bold">Rejected</span>
            </div>
            <p class="text-3xl font-bold text-red-700 mb-1">
                {{ $payments->where('status_pembayaran', 'ditolak')->count() }}
            </p>
            <p class="text-xs text-red-600">Pembayaran Ditolak</p>
        </div>
    </div>

    <!-- Payment List -->
    @if ($payments->count() > 0)
        <div class="space-y-4">
            @foreach ($payments as $payment)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-all">
                    <div class="p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <!-- Left: Payment Info -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-lg">
                                            {{ substr($payment->booking->user->name, 0, 1) }}
                                        </span>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="font-bold text-slate-900">
                                                {{ $payment->booking->user->name }}
                                            </h3>
                                            @if ($payment->status_pembayaran == 'pending')
                                                <span
                                                    class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">
                                                    Pending
                                                </span>
                                            @elseif ($payment->status_pembayaran == 'terverifikasi')
                                                <span
                                                    class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-bold">
                                                    ✓ Verified
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-bold">
                                                    ✗ Ditolak
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-600 mb-2">
                                            {{ $payment->booking->studio->nama_studio }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($payment->booking->tanggal_booking)->format('d M Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ucfirst($payment->tipe_pembayaran) }}
                                                • {{ strtoupper($payment->metode_pembayaran) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Amount & Actions -->
                            <div class="flex items-center gap-4">
                                <!-- Amount -->
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-amber-600">
                                        Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $payment->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <button
                                        onclick="openDetailModal({{ json_encode($payment->load(['booking.user', 'booking.studio'])) }})"
                                        class="p-2.5 text-slate-600 hover:bg-slate-100 rounded-lg transition"
                                        title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    @if ($payment->status_pembayaran == 'pending')
                                        <button onclick="openVerifyModal({{ $payment->id }})"
                                            class="p-2.5 text-green-600 hover:bg-green-50 rounded-lg transition"
                                            title="Verifikasi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="openRejectModal({{ $payment->id }})"
                                            class="p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Tolak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            {{ $payments->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                </path>
            </svg>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak Ada Data</h3>
            <p class="text-sm text-slate-500">Tidak ada pembayaran yang ditemukan dengan filter saat ini.</p>
        </div>
    @endif
    </div>
    </div>

    <!-- Modal Verify -->
    <div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Verifikasi Pembayaran</h3>
                    <p class="text-xs text-slate-500">Konfirmasi pembayaran customer</p>
                </div>
            </div>
            <form id="verifyForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan_admin" rows="3"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"
                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-bold text-sm shadow-sm">
                        ✓ Verifikasi
                    </button>
                    <button type="button" onclick="closeVerifyModal()"
                        class="flex-1 bg-slate-100 text-slate-700 py-3 rounded-lg hover:bg-slate-200 transition font-semibold text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tolak Pembayaran</h3>
                    <p class="text-xs text-slate-500">Berikan alasan penolakan</p>
                </div>
            </div>
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="catatan_admin" rows="4" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 text-sm"
                        placeholder="Jelaskan alasan penolakan pembayaran ini..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition font-bold text-sm shadow-sm">
                        ✗ Tolak Pembayaran
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-slate-100 text-slate-700 py-3 rounded-lg hover:bg-slate-200 transition font-semibold text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Detail Pembayaran</h3>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div id="detailContent"></div>
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

            function openDetailModal(payment) {
                const content = document.getElementById('detailContent');
                const buktiUrl = `{{ asset('uploads/payments') }}/${payment.bukti_transfer}`;

                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <img src="${buktiUrl}" alt="Bukti Transfer" class="w-full h-auto max-h-96 object-contain rounded-lg">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Customer</p>
                                <p class="font-bold text-slate-800">${payment.booking.user.name}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Studio</p>
                                <p class="font-bold text-slate-800">${payment.booking.studio.nama_studio}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Tanggal Booking</p>
                                <p class="text-sm text-slate-700">${new Date(payment.booking.tanggal_booking).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Jumlah Bayar</p>
                                <p class="text-xl font-bold text-amber-600">Rp ${Number(payment.jumlah_bayar).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4 border-t">
                            <button onclick="closeDetailModal()" class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                                Tutup
                            </button>
                        </div>
                    </div>
                `;
                document.getElementById('detailModal').classList.remove('hidden');
            }

            function closeDetailModal() {
                document.getElementById('detailModal').classList.add('hidden');
            }

            // Close modals on outside click
            ['verifyModal', 'rejectModal', 'detailModal'].forEach(modalId => {
                document.getElementById(modalId)?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush

@endsection
