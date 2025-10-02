@extends('layouts.admin')

@section('title', 'Tambah Studio')
@section('page-title', 'Tambah Studio Baru')
@section('page-subtitle', 'Tambahkan studio musik baru')

@section('content')

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('admin.studio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Studio -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Nama Studio <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_studio" value="{{ old('nama_studio') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Contoh: Studio A - Professional">
                    @error('nama_studio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Deskripsi lengkap tentang studio...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Contoh: Jl. Dago No. 123, Bandung">
                    @error('lokasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Per Jam -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Harga per Jam <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                        <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam') }}" required
                            min="0"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            placeholder="150000">
                    </div>
                    @error('harga_per_jam')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Gambar Studio</label>
                    <input type="file" name="gambar" accept="image/*" id="gambar"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    @error('gambar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Status <span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="aktif" checked
                                class="w-4 h-4 text-teal-600 focus:ring-teal-500">
                            <span class="ml-2 text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="nonaktif"
                                class="w-4 h-4 text-teal-600 focus:ring-teal-500">
                            <span class="ml-2 text-gray-700">Nonaktif</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-4 border-t">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                        Simpan Studio
                    </button>
                    <a href="{{ route('admin.studio.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Image Preview
            document.getElementById('gambar').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('imagePreview');
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush

@endsection
