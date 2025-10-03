@extends('layouts.customer')

@section('title', 'Booking Studio')

@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('customer.studio.show', $studio->id) }}"
                class="inline-flex items-center text-sm text-amber-600 hover:text-amber-700 mb-6 font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Studio Info -->
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-amber-50 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">{{ $studio->nama_studio }}</h2>
                                <p class="text-sm text-slate-600">{{ $studio->lokasi }}</p>
                                <p class="text-base font-bold text-amber-600 mt-1">
                                    Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}/jam
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Detail Booking</h3>

                        <form id="bookingForm">
                            @csrf
                            <input type="hidden" name="studio_id" value="{{ $studio->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_booking" id="tanggal_booking"
                                        min="{{ date('Y-m-d') }}" required
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Jam Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" required
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Durasi (Jam) <span class="text-red-500">*</span>
                                </label>
                                <select name="durasi_jam" id="durasi_jam" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                                    <option value="">Pilih Durasi</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }} Jam</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                                <textarea name="catatan" id="catatan" rows="2"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm"
                                    placeholder="Tambahkan catatan..."></textarea>
                            </div>

                            <!-- Total Preview -->
                            <div id="totalHargaBox" class="bg-amber-50 rounded-lg p-4 border border-amber-200 mb-4"
                                style="display:none;">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-700">Harga/jam:</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-700">Durasi:</span>
                                    <span class="font-semibold"><span id="displayDurasi">0</span> jam</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-700">Waktu:</span>
                                    <span class="font-semibold" id="displayJamRange">-</span>
                                </div>
                                <div class="border-t border-amber-300 pt-2 mt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-slate-800">Total:</span>
                                        <span class="text-2xl font-bold text-amber-600" id="displayTotal">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="checkBtn"
                                class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors text-sm shadow-sm">
                                Cek Ketersediaan
                            </button>

                            <div id="messageBox" class="mt-4" style="display:none;"></div>
                        </form>
                    </div>

                    <!-- Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-xs font-bold text-blue-900 mb-2">Info FCFS</p>
                        <p class="text-xs text-blue-700">
                            Jadwal diberikan kepada customer yang booking terlebih dahulu. Pastikan cek ketersediaan sebelum
                            booking.
                        </p>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="lg:col-span-1">
                    <div id="paymentSection" class="bg-white rounded-xl shadow-sm p-5 sticky top-20" style="display:none;">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Pembayaran</h3>

                        <form action="{{ route('customer.booking.store') }}" method="POST" id="paymentForm"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                            <input type="hidden" name="tanggal_booking" id="payment_tanggal">
                            <input type="hidden" name="jam_mulai" id="payment_jam">
                            <input type="hidden" name="durasi_jam" id="payment_durasi">
                            <input type="hidden" name="catatan" id="payment_catatan">

                            @php
                                $qrisSetting = \App\Models\QrisSetting::aktif()->first();
                            @endphp
                            @if ($qrisSetting)
                                <div class="bg-slate-50 rounded-lg p-3 mb-4 text-center border border-slate-200">
                                    <p class="text-xs text-slate-600 mb-2 font-semibold">Scan QR Code:</p>
                                    <div class="bg-white p-3 rounded-lg inline-block shadow-sm">
                                        <img src="{{ asset('uploads/qris/' . $qrisSetting->qr_code_image) }}"
                                            alt="QR Code" class="w-40 h-40 mx-auto">
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Bayar <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" required min="1"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                                <p class="text-xs text-slate-500 mt-1">Minimal Rp 1</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tipe <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe_pembayaran" id="tipe_pembayaran" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 text-sm">
                                    <option value="lunas">Lunas</option>
                                    <option value="dp">DP</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Bukti Transfer <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="bukti_transfer" id="bukti_transfer" required
                                    accept="image/*"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer border border-slate-300 rounded-lg">
                                <p class="text-xs text-slate-500 mt-1">JPG, PNG (Max: 2MB)</p>
                            </div>

                            <button type="submit"
                                class="w-full bg-amber-600 text-white py-3 rounded-lg font-bold hover:bg-amber-700 transition-colors text-sm shadow-sm">
                                Konfirmasi & Bayar
                            </button>

                            <p class="text-xs text-center text-slate-500 mt-3">
                                Dengan melanjutkan, Anda menyetujui <a href="#"
                                    class="text-amber-600 hover:underline">S&K</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            const hargaPerJam = {{ $studio->harga_per_jam }};
            const studioId = {{ $studio->id }};
            const checkUrl = "{{ route('customer.booking.check') }}";
            const csrfToken = "{{ csrf_token() }}";

            function updateCalculation() {
                const durasi = document.getElementById('durasi_jam').value;
                const jamMulai = document.getElementById('jam_mulai').value;

                if (durasi && jamMulai) {
                    const total = hargaPerJam * durasi;
                    document.getElementById('displayDurasi').textContent = durasi;
                    document.getElementById('displayTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');

                    const [hours, minutes] = jamMulai.split(':');
                    const startTime = new Date();
                    startTime.setHours(parseInt(hours), parseInt(minutes));

                    const endTime = new Date(startTime);
                    endTime.setHours(endTime.getHours() + parseInt(durasi));

                    const endTimeStr = endTime.getHours().toString().padStart(2, '0') + ':' +
                        endTime.getMinutes().toString().padStart(2, '0');

                    document.getElementById('displayJamRange').textContent = jamMulai + ' - ' + endTimeStr;
                    document.getElementById('totalHargaBox').style.display = 'block';

                    document.getElementById('jumlah_bayar').max = total;
                    document.getElementById('jumlah_bayar').placeholder = 'Max: Rp ' + total.toLocaleString('id-ID');
                } else {
                    document.getElementById('totalHargaBox').style.display = 'none';
                }
            }

            document.getElementById('durasi_jam').addEventListener('change', updateCalculation);
            document.getElementById('jam_mulai').addEventListener('change', updateCalculation);

            document.getElementById('checkBtn').addEventListener('click', async function() {
                const tanggal = document.getElementById('tanggal_booking').value;
                const jamMulai = document.getElementById('jam_mulai').value;
                const durasi = document.getElementById('durasi_jam').value;
                const messageBox = document.getElementById('messageBox');
                const paymentSection = document.getElementById('paymentSection');

                if (!tanggal || !jamMulai || !durasi) {
                    messageBox.innerHTML =
                        '<div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-3 py-2 rounded-lg text-xs"><strong>⚠️ Perhatian!</strong> Lengkapi semua field wajib!</div>';
                    messageBox.style.display = 'block';
                    paymentSection.style.display = 'none';
                    return;
                }

                this.disabled = true;
                this.innerHTML = '⏳ Mengecek...';

                try {
                    const response = await fetch(checkUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            studio_id: studioId,
                            tanggal_booking: tanggal,
                            jam_mulai: jamMulai,
                            durasi_jam: durasi
                        })
                    });

                    const data = await response.json();

                    if (data.available) {
                        messageBox.innerHTML =
                            '<div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-xs"><strong>✅ Tersedia!</strong> ' +
                            data.message + '</div>';
                        messageBox.style.display = 'block';
                        paymentSection.style.display = 'block';

                        document.getElementById('payment_tanggal').value = tanggal;
                        document.getElementById('payment_jam').value = jamMulai;
                        document.getElementById('payment_durasi').value = durasi;
                        document.getElementById('payment_catatan').value = document.getElementById('catatan').value;

                        paymentSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        messageBox.innerHTML =
                            '<div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-xs"><strong>❌ Tidak Tersedia</strong> ' +
                            data.message + '</div>';
                        messageBox.style.display = 'block';
                        paymentSection.style.display = 'none';
                    }
                } catch (error) {
                    messageBox.innerHTML =
                        '<div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-xs"><strong>❌ Error</strong> Tidak dapat memeriksa ketersediaan.</div>';
                    messageBox.style.display = 'block';
                    paymentSection.style.display = 'none';
                }
                this.disabled = false;
                this.innerHTML = 'Cek Ketersediaan';
            });
        </script>
    @endpush
@endsection
