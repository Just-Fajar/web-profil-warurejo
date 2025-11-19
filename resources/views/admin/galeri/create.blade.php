@extends('admin.layouts.app')

@section('title', 'Tambah Galeri Baru')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Galeri</h1>
            <p class="text-muted small mb-0">Upload momen atau informasi terbaru desa.</p>
        </div>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="galeriForm">
        @csrf

        <!-- Hidden: jenis media otomatis FOTO -->
        <input type="hidden" name="jenis_media" value="foto">

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body p-4">
                        
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="fas fa-pen me-2"></i>Konten Galeri
                        </h6>

                        <!-- JUDUL -->
                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Galeri <span class="text-red-500">*</span>
                            </label>

                            <input type="text"
                                   name="judul"
                                   id="judul"
                                   value="{{ old('judul') }}"
                                   required
                                   placeholder="Masukkan judul..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg
                                          focus:ring-2 focus:ring-primary-500 focus:border-primary-500
                                          @error('judul') border-red-500 @enderror">

                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      id="deskripsi"
                                      rows="6"
                                      placeholder="Ceritakan detail tentang foto ini..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                                             focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                             @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-gray-500 text-right mt-1">
                                Opsional, tetapi disarankan diisi.
                            </p>
                        </div>

                        <!-- MEDIA UPLOAD — HANYA FOTO -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Media (Foto Saja)
                            </label>

                            <div id="uploadArea"
                                 class="border-2 border-dashed border-gray-300 rounded-lg p-4 
                                 text-center bg-gray-50 hover:border-primary-500 transition cursor-pointer relative">

                                <input type="file"
                                       id="gambar"
                                       name="gambar"
                                       accept="image/*"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       required>

                                <!-- Placeholder -->
                                <div id="uploadPlaceholder">
                                    <div class="text-gray-400 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-gray-700">Klik atau Tarik Gambar</p>
                                    <p class="text-xs text-gray-500">Format: JPG, PNG, WEBP (Max 2MB)</p>
                                </div>

                                <!-- Preview -->
                                <div id="previewContainer" class="hidden relative mt-3">
                                    <img id="imagePreview"
                                         src="#"
                                         class="w-full h-64 object-cover rounded-lg shadow">

                                    <button type="button"
                                            onclick="resetUpload()"
                                            class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full shadow">
                                        ✕
                                    </button>
                                </div>
                            </div>

                            @error('gambar')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- KATEGORI -->
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 font-medium mb-2">Kategori <span class="text-red-500">*</span></label>

                            <select name="kategori" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white 
                                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                <option value="">-- Pilih Kategori --</option>
                                <option value="kegiatan">Kegiatan Desa</option>
                                <option value="infrastruktur">Infrastruktur</option>
                                <option value="budaya">Budaya</option>
                                <option value="umkm">UMKM</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- TANGGAL -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kejadian</label>

                            <input type="date" 
                                   name="tanggal"
                                   value="{{ old('tanggal', date('Y-m-d')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                                          focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <!-- STATUS -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Publish</label>

                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       checked
                                       class="h-5 w-5 text-primary-600 rounded border-gray-300">
                                <span class="text-gray-700">Tampilkan di Website</span>
                            </label>
                        </div>

                        <hr>

                        <div class="mt-4">
                            <button type="submit"
                                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold 
                                           py-3 rounded-lg shadow-md transition">
                                Simpan Galeri
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('gambar').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;

            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.getElementById('previewContainer').classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }
});

function resetUpload() {
    document.getElementById('gambar').value = "";
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('previewContainer').classList.add('hidden');
    document.getElementById('imagePreview').src = "";
}
</script>
@endpush

@endsection
