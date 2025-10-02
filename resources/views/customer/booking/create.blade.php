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
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Form Booking Studio</h2>
                    <p class="text-gray-600 mb-6">Isi form di bawah untuk melakukan booking studio</p>

                    <form action="{{ route('customer.booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="studio_id" value="{{ $studio->id }}">

                        <!-- Tanggal Booking -->
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Tanggal Booking <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_booking" id="tanggal_booking" min="{{ date('Y-m-d') }}"
                                value="{{ old('tanggal_booking') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                            @error('tanggal_booking')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jam Mulai -->
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Jam Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                            @error('jam_mulai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div class="mb-5">
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
                            @error('durasi_jam')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                placeholder="Tambahkan catatan khusus untuk booking Anda...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Harga Preview -->
                        <div id="totalHargaBox"
                            class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg p-5 mb-5 border border-teal-200"
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
                            class="w-full bg-cyan-600 text-white py-3 rounded-lg font-medium hover:bg-cyan-700 transition mb-4 shadow-lg">
                            🔍 Cek Ketersediaan Jadwal
                        </button>

                        <!-- Message Box -->
                        <div id="messageBox" class="mb-4" style="display:none;"></div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" style="display:none;"
                            class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                            ✅ Konfirmasi Booking
                        </button>

                        <!-- Info FCFS -->
                        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-blue-800 text-sm mb-1">Sistem FCFS (First Come First
                                        Served)</p>
                                    <p class="text-blue-700 text-sm">
                                        Jadwal yang tersedia akan diberikan kepada customer yang melakukan booking terlebih
                                        dahulu.
                                        Pastikan Anda memeriksa ketersediaan sebelum melakukan booking.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Studio Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-20">
                    <!-- Studio Image -->
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center">
                        @if ($studio->gambar)
                            <img src="{{ asset('uploads/studios/' . $studio->gambar) }}" alt="{{ $studio->nama_studio }}"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                </path>
                            </svg>
                        @endif
                    </div>

                    <!-- Studio Details -->
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-3">{{ $studio->nama_studio }}</h3>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-teal-600 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">{{ $studio->lokasi }}</p>
                            </div>

                            @if ($studio->deskripsi)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-teal-600 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600">{{ Str::limit($studio->deskripsi, 100) }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                            <p class="text-sm text-teal-700 mb-1">Harga per Jam</p>
                            <p class="text-2xl font-bold text-teal-600">Rp
                                {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</p>
                        </div>
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
                const submitBtn = document.getElementById('submitBtn');

                if (!tanggal || !jamMulai || !durasi) {
                    messageBox.innerHTML =
                        '<div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg text-sm"><strong>⚠️ Perhatian!</strong><br>Mohon lengkapi semua field yang wajib diisi!</div>';
                    messageBox.style.display = 'block';
                    submitBtn.style.display = 'none';
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
                            data.message +
                            '<br><span class="text-xs">Klik tombol di bawah untuk konfirmasi booking.</span></div>';
                        messageBox.style.display = 'block';
                        submitBtn.style.display = 'block';
                    } else {
                        messageBox.innerHTML =
                            '<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><strong>❌ Jadwal Tidak Tersedia</strong><br>' +
                            data.message +
                            '<br><span class="text-xs">Silakan pilih tanggal atau waktu lain.</span></div>';
                        messageBox.style.display = 'block';
                        submitBtn.style.display = 'none';
                    }
                } catch (error) {
                    messageBox.innerHTML =
                        '<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><strong>❌ Terjadi Kesalahan</strong><br>Tidak dapat memeriksa ketersediaan. Silakan coba lagi.</div>';
                    messageBox.style.display = 'block';
                    submitBtn.style.display = 'none';
                }

                this.disabled = false;
                this.innerHTML = '🔍 Cek Ketersediaan Jadwal';
            });
        </script>
    @endpush
@endsection
