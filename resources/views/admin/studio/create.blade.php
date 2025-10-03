@extends('layouts.admin')

@section('title', 'Tambah Studio')
@section('page-title', 'Tambah Studio Baru')
@section('page-subtitle', 'Tambahkan studio musik baru ke dalam sistem')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
            <form action="{{ route('admin.studio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Nama Studio <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_studio" value="{{ old('nama_studio') }}" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Contoh: Studio A - Professional">
                            @error('nama_studio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Lokasi <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Contoh: Jl. Dago No. 123, Bandung">
                            @error('lokasi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Harga per Jam <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-500">Rp</span>
                                <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam') }}" required
                                    min="0"
                                    class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    placeholder="150000">
                            </div>
                            @error('harga_per_jam')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Status <span
                                    class="text-red-500">*</span></label>
                            <div class="flex items-center space-x-6 bg-slate-50 p-3 rounded-lg border border-slate-200">
                                <label class="flex items-center"><input type="radio" name="status" value="aktif" checked
                                        class="w-4 h-4 text-amber-600 focus:ring-amber-500"><span
                                        class="ml-2 text-slate-700">Aktif</span></label>
                                <label class="flex items-center"><input type="radio" name="status" value="nonaktif"
                                        class="w-4 h-4 text-amber-600 focus:ring-amber-500"><span
                                        class="ml-2 text-slate-700">Nonaktif</span></label>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="7"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Deskripsi lengkap tentang studio...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium mb-2">Gambar Studio</label>
                            <input type="file" name="gambar" accept="image/*" id="gambar"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                            @error('gambar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div id="imagePreview" class="mt-3 hidden"><img src="" alt="Preview"
                                    class="w-full h-48 object-cover rounded-lg border"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 pt-6 mt-6 border-t border-slate-200">
                    <button type="submit"
                        class="px-6 py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition shadow-md">Simpan
                        Studio</button>
                    <a href="{{ route('admin.studio.index') }}"
                        class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('gambar').addEventListener('change', function(e) {
                /* ... (logika preview gambar sama) ... */ });
        </script>
    @endpush

@endsection
