@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')
@section('page-subtitle', 'Kelola dan verifikasi pembayaran dari customer')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <h3 class="font-semibold text-slate-800 mb-4">Filter Data</h3>
                <form action="{{ route('admin.payment.index') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2">Status Pembayaran</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>
                                Terverifikasi</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="w-full px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold text-sm">Filter</button>
                        <a href="{{ route('admin.payment.index') }}"
                            class="w-full text-center px-5 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium text-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-yellow-200">
                    <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">
                        {{ $payments->where('status_pembayaran', 'pending')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-green-200">
                    <p class="text-sm text-slate-500">Terverifikasi</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">
                        {{ $payments->where('status_pembayaran', 'terverifikasi')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-red-200">
                    <p class="text-sm text-slate-500">Ditolak</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">
                        {{ $payments->where('status_pembayaran', 'ditolak')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        @if ($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Customer</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Booking</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Jumlah Bayar</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-600">Status</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $payment->booking->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $payment->booking->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $payment->booking->studio->nama_studio }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($payment->booking->tanggal_booking)->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800 text-base">Rp
                                        {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $payment->tipe_pembayaran == 'dp' ? 'DP' : ucfirst($payment->tipe_pembayaran) }}
                                        - {{ strtoupper($payment->metode_pembayaran) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($payment->status_pembayaran == 'pending')
                                        <span
                                            class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold border border-yellow-200">Pending</span>
                                    @elseif ($payment->status_pembayaran == 'terverifikasi')
                                        <span
                                            class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">Terverifikasi</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold border border-red-200">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button
                                            onclick="openDetailModal({{ json_encode($payment->load(['booking.user', 'booking.studio'])) }})"
                                            class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition"
                                            title="Lihat Detail Pembayaran">
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
                                                class="p-2 text-green-600 hover:bg-green-100 rounded-full transition"
                                                title="Verifikasi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="openRejectModal({{ $payment->id }})"
                                                class="p-2 text-red-600 hover:bg-red-100 rounded-full transition"
                                                title="Tolak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50">{{ $payments->links() }}</div>
        @else
            <div class="p-16 text-center">
                <p class="text-slate-500">Tidak ada data pembayaran yang ditemukan.</p>
            </div>
        @endif
    </div>

    <div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Verifikasi Pembayaran</h3>
            <form id="verifyForm" method="POST" class="space-y-4">@csrf<div><label
                        class="block text-slate-700 text-sm font-medium mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan_admin" rows="3"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500"></textarea>
                </div>
                <div class="flex gap-3"><button type="submit"
                        class="flex-1 bg-green-600 text-white py-2.5 rounded-lg hover:bg-green-700 transition font-medium">Verifikasi</button><button
                        type="button" onclick="closeVerifyModal()"
                        class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-lg hover:bg-slate-200 transition font-medium">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Tolak Pembayaran</h3>
            <form id="rejectForm" method="POST" class="space-y-4">@csrf<div><label
                        class="block text-slate-700 text-sm font-medium mb-2">Alasan Penolakan <span
                            class="text-red-500">*</span></label>
                    <textarea name="catatan_admin" rows="4" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500"></textarea>
                </div>
                <div class="flex gap-3"><button type="submit"
                        class="flex-1 bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 transition font-medium">Tolak</button><button
                        type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-lg hover:bg-slate-200 transition font-medium">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-lg w-full">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Detail Pembayaran</h3>
            <div id="detailContent" class="space-y-4"></div><button type="button" onclick="closeDetailModal()"
                class="mt-6 w-full bg-slate-100 text-slate-700 py-2.5 rounded-lg hover:bg-slate-200 transition font-medium">Tutup</button>
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

            function openDetailModal(payment) {
                const content = document.getElementById('detailContent');
                const buktiUrl = `{{ asset('uploads/payments') }}/${payment.bukti_transfer}`;
                content.innerHTML = `
                    <img src="${buktiUrl}" alt="Bukti Transfer" class="w-full h-auto max-h-96 object-contain rounded-lg border border-slate-200">
                    <div class="text-sm space-y-2 mt-4">
                        <div class="flex justify-between"><span class="text-slate-500">Customer:</span><span class="font-semibold text-slate-800">${payment.booking.user.name}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Studio:</span><span class="font-semibold text-slate-800">${payment.booking.studio.nama_studio}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Jumlah Bayar:</span><span class="font-bold text-lg text-amber-600">Rp ${Number(payment.jumlah_bayar).toLocaleString('id-ID')}</span></div>
                    </div>
                `;
                document.getElementById('detailModal').classList.remove('hidden');
            }

            function closeDetailModal() {
                document.getElementById('detailModal').classList.add('hidden');
            }
        </script>
    @endpush
@endsection
