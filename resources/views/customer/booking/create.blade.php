@extends('layouts.customer')

@section('title', 'Booking Studio')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <a href="{{ route('customer.studio.show', $studio->id) }}"
            class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Studio
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Studio Info Card -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if ($studio->gambar)
                                <img src="{{ asset('uploads/studios/' . $studio->gambar) }}"
                                    alt="{{ $studio->nama_studio }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                    </path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-gray-800">{{ $studio->nama_studio }}</h2>
                            <p class="text-sm text-gray-600">{{ $studio->lokasi }}</p>
                            <p class="text-lg font-bold text-teal-600 mt-1">Rp
                                {{ number_format($studio->harga_per_jam, 0, ',', '.') }}<span
                                    class="text-sm font-normal text-gray-500">/jam</span></p>
                        </div>
                    </div>
                </div>

                <!-- Booking Form Card -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">📅 Detail Booking</h3>

                    <form id="bookingForm">
                        @csrf
                        <input type="hidden" name="studio_id" value="{{ $studio->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Tanggal Booking -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Tanggal Booking <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_booking" id="tanggal_booking" min="{{ date('Y-m-d') }}"
                                    value="{{ old('tanggal_booking') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                            </div>

                            <!-- Jam Mulai -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <!-- Durasi -->
                        <div class="mt-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Durasi (Jam) <span class="text-red-500">*</span>
                            </label>
                            <select name="durasi_jam" id="durasi_jam" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                                <option value="">Pilih Durasi</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('durasi_jam') == $i ? 'selected' : '' }}>
                                        {{ $i }} Jam
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="mt-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                placeholder="Tambahkan catatan khusus untuk booking Anda...">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Total Harga Preview -->
                        <div id="totalHargaBox"
                            class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg p-5 mt-5 border border-teal-200"
                            style="display:none;">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-700">Harga per jam:</span>
                                <span class="font-medium text-gray-800">Rp
                                    {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-700">Durasi:</span>
                                <span class="font-medium text-gray-800"><span id="displayDurasi">0</span> jam</span>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-700">Jam booking:</span>
                                <span class="font-medium text-gray-800" id="displayJamRange">-</span>
                            </div>
                            <div class="border-t border-teal-300 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-800 font-semibold text-lg">Total Harga:</span>
                                    <span class="text-2xl font-bold text-teal-600" id="displayTotal">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Check Availability Button -->
                        <button type="button" id="checkBtn"
                            class="w-full bg-cyan-600 text-white py-3 rounded-lg font-medium hover:bg-cyan-700 transition mt-5 shadow-lg">
                            🔍 Cek Ketersediaan Jadwal
                        </button>

                        <!-- Message Box -->
                        <div id="messageBox" class="mt-4" style="display:none;"></div>
                    </form>
                </div>

                <!-- Info FCFS -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-800 mb-1">Sistem FCFS (First Come First Served)</p>
                            <p class="text-blue-700 text-sm">
                                Jadwal yang tersedia akan diberikan kepada customer yang melakukan booking terlebih dahulu.
                                Pastikan Anda memeriksa ketersediaan sebelum melakukan booking.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section (Hidden by default) -->
            <div class="lg:col-span-1">
                <div id="paymentSection" class="bg-white rounded-xl shadow-md p-6 sticky top-20" style="display:none;">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">💳 Pembayaran</h3>

                    <form action="{{ route('customer.booking.store') }}" method="POST" id="paymentForm"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                        <input type="hidden" name="tanggal_booking" id="payment_tanggal">
                        <input type="hidden" name="jam_mulai" id="payment_jam">
                        <input type="hidden" name="durasi_jam" id="payment_durasi">
                        <input type="hidden" name="catatan" id="payment_catatan">

                        <!-- QR Code -->
                        @php
                            $qrisSetting = \App\Models\QrisSetting::aktif()->first();
                        @endphp
                        @if ($qrisSetting)
                            <div class="bg-gray-50 rounded-lg p-4 mb-5 text-center border border-gray-200">
                                <p class="text-sm text-gray-600 mb-3 font-medium">Scan QR Code untuk pembayaran:</p>
                                <div class="bg-white p-4 rounded-lg inline-block shadow-sm">
                                    <img src="{{ asset('uploads/qris/' . $qrisSetting->qr_code_image) }}" alt="QR Code"
                                        class="w-48 h-48 mx-auto">
                                </div>
                                <p class="text-xs text-gray-500 mt-3">{{ $qrisSetting->nama_merchant }}</p>
                            </div>
                        @endif

                        <!-- Jumlah Bayar -->
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Jumlah Bayar <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" required min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Minimal Rp 1</p>
                        </div>

                        <!-- Tipe Pembayaran -->
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Tipe Pembayaran <span
                                    class="text-red-500">*</span></label>
                            <select name="tipe_pembayaran" id="tipe_pembayaran" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="lunas">Lunas</option>
                                <option value="dp">DP (Down Payment)</option>
                            </select>
                        </div>

                        <!-- Bukti Transfer -->
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Bukti Transfer <span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="bukti_transfer" id="bukti_transfer" required accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer border border-gray-300 rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3 rounded-lg font-bold hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                            ✅ Konfirmasi Booking & Bayar
                        </button>

                        <p class="text-xs text-center text-gray-500 mt-3">
                            Dengan melanjutkan, Anda menyetujui <a href="#"
                                class="text-teal-600 hover:underline">Syarat
                                & Ketentuan</a>
                        </p>
                    </form>
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

            // Calculate total and time range
            function updateCalculation() {
                const durasi = document.getElementById('durasi_jam').value;
                const jamMulai = document.getElementById('jam_mulai').value;

                if (durasi && jamMulai) {
                    const total = hargaPerJam * durasi;
                    document.getElementById('displayDurasi').textContent = durasi;
                    document.getElementById('displayTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');

                    // Calculate end time
                    const [hours, minutes] = jamMulai.split(':');
                    const startTime = new Date();
                    startTime.setHours(parseInt(hours), parseInt(minutes));

                    const endTime = new Date(startTime);
                    endTime.setHours(endTime.getHours() + parseInt(durasi));

                    const endTimeStr = endTime.getHours().toString().padStart(2, '0') + ':' +
                        endTime.getMinutes().toString().padStart(2, '0');

                    document.getElementById('displayJamRange').textContent = jamMulai + ' - ' + endTimeStr;
                    document.getElementById('totalHargaBox').style.display = 'block';

                    // Set max jumlah bayar
                    document.getElementById('jumlah_bayar').max = total;
                    document.getElementById('jumlah_bayar').placeholder = 'Max: Rp ' + total.toLocaleString('id-ID');
                } else {
                    document.getElementById('totalHargaBox').style.display = 'none';
                }
            }

            document.getElementById('durasi_jam').addEventListener('change', updateCalculation);
            document.getElementById('jam_mulai').addEventListener('change', updateCalculation);

            // Check availability
            document.getElementById('checkBtn').addEventListener('click', async function() {
                const tanggal = document.getElementById('tanggal_booking').value;
                const jamMulai = document.getElementById('jam_mulai').value;
                const durasi = document.getElementById('durasi_jam').value;
                const messageBox = document.getElementById('messageBox');
                const paymentSection = document.getElementById('paymentSection');

                if (!tanggal || !jamMulai || !durasi) {
                    messageBox.innerHTML =
                        '<div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg text-sm"><strong>⚠️ Perhatian!</strong><br>Mohon lengkapi semua field yang wajib diisi!</div>';
                    messageBox.style.display = 'block';
                    paymentSection.style.display = 'none';
                    return;
                }

                this.disabled = true;
                this.innerHTML = '⏳ Mengecek ketersediaan...';

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
                            '<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm"><strong>✅ Jadwal Tersedia!</strong><br>' +
                            data.message + '</div>';
                        messageBox.style.display = 'block';

                        // Show payment section
                        paymentSection.style.display = 'block';

                        // Copy data to payment form
                        document.getElementById('payment_tanggal').value = tanggal;
                        document.getElementById('payment_jam').value = jamMulai;
                        document.getElementById('payment_durasi').value = durasi;
                        document.getElementById('payment_catatan').value = document.getElementById('catatan')
                            .value;

                        // Smooth scroll to payment section
                        paymentSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        messageBox.innerHTML =
                            '<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><strong>❌ Jadwal Tidak Tersedia</strong><br>' +
                            data.message +
                            '<br><span class="text-xs">Silakan pilih tanggal atau waktu lain.</span></div>';
                        messageBox.style.display = 'block';
                        paymentSection.style.display = 'none';
                    }
                } catch (error) {
                    messageBox.innerHTML =
                        '<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><strong>❌ Terjadi Kesalahan</strong><br>Tidak dapat memeriksa ketersediaan. Silakan coba lagi.</div>';
                    messageBox.style.display = 'block';
                    paymentSection.style.display = 'none';
                }
                this.disabled = false;
                this.innerHTML = '🔍 Cek Ketersediaan Jadwal';
            });
        </script>
    @endpush
@endsection
