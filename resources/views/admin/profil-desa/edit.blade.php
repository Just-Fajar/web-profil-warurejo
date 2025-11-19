@extends('admin.layouts.app')

@section('title', 'Edit Profil Desa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit Profil Desa</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-images text-primary mr-2"></i>
                        Edit Gambar Profil Desa
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kelola gambar header dan struktur organisasi desa
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil-desa.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Petunjuk -->
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Petunjuk Upload Gambar
                            </h5>
                            <hr>
                            <ul class="mb-0 pl-3">
                                <li><strong>Gambar Header:</strong> Banner yang tampil di homepage (Sambutan Kepala Desa). Ukuran disarankan: 1920x600px (landscape lebar)</li>
                                <li><strong>Struktur Organisasi:</strong> Bagan struktur organisasi desa. Bisa dibuat di Canva/PowerPoint lalu screenshot. Ukuran disarankan: 1920x1080px</li>
                                <li>Format: JPEG, PNG, WEBP</li>
                                <li>Maksimal ukuran: 5MB per gambar</li>
                            </ul>
                        </div>

                        <div class="row">
                            <!-- Gambar Header -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-primary h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-image mr-2"></i>
                                            Gambar Header (Homepage)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($profil->gambar_header)
                                            <div class="text-center mb-3 p-3" style="background: #f8f9fa; border-radius: 10px;">
                                                <img src="{{ Storage::url($profil->gambar_header) }}" 
                                                     alt="Gambar Header" 
                                                     class="img-fluid rounded shadow-sm" 
                                                     style="max-height: 300px; border: 3px solid #007bff;">
                                                <p class="text-muted mt-2 mb-0">
                                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                                    Gambar header saat ini
                                                </p>
                                            </div>
                                        @else
                                            <div class="text-center mb-3 p-5" style="background: #f8f9fa; border-radius: 10px; border: 2px dashed #dee2e6;">
                                                <i class="fas fa-image text-muted" style="font-size: 64px;"></i>
                                                <p class="text-muted mt-3 mb-0">Belum ada gambar header</p>
                                                <small class="text-muted">Upload gambar untuk banner homepage</small>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-upload mr-1"></i>
                                                Upload Gambar Header Baru
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" 
                                                       name="gambar_header" 
                                                       class="custom-file-input @error('gambar_header') is-invalid @enderror" 
                                                       id="gambar_header"
                                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                                <label class="custom-file-label" for="gambar_header">Pilih gambar...</label>
                                            </div>
                                            <small class="form-text text-muted mt-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Banner homepage (Sambutan Kepala Desa)<br>
                                                <i class="fas fa-file-image mr-1"></i>
                                                Format: JPEG, PNG, WEBP<br>
                                                <i class="fas fa-weight mr-1"></i>
                                                Maksimal: 5MB<br>
                                                <i class="fas fa-expand-arrows-alt mr-1"></i>
                                                Ukuran disarankan: 1920x600px (landscape lebar)
                                            </small>
                                            @error('gambar_header')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview -->
                                        <div id="preview_header" class="mt-3" style="display: none;">
                                            <p class="font-weight-bold mb-2">Preview:</p>
                                            <img id="preview_header_img" src="" alt="Preview" class="img-fluid rounded shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Struktur Organisasi -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-success h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-sitemap mr-2"></i>
                                            Struktur Organisasi
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($profil->struktur_organisasi)
                                            <div class="text-center mb-3 p-3" style="background: #f8f9fa; border-radius: 10px;">
                                                <img src="{{ Storage::url($profil->struktur_organisasi) }}" 
                                                     alt="Struktur Organisasi Desa {{ $profil->nama_desa }}" 
                                                     class="img-fluid rounded shadow-sm" 
                                                     style="max-height: 500px; border: 3px solid #007bff;">
                                                <p class="text-muted mt-2 mb-0">
                                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                                    Struktur organisasi saat ini
                                                </p>
                                            </div>
                                        @else
                                            <div class="text-center mb-3 p-5" style="background: #f8f9fa; border-radius: 10px; border: 2px dashed #dee2e6;">
                                                <i class="fas fa-sitemap text-muted" style="font-size: 64px;"></i>
                                                <p class="text-muted mt-3 mb-0">Belum ada struktur organisasi</p>
                                                <small class="text-muted">Upload bagan struktur organisasi desa</small>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-upload mr-1"></i>
                                                Upload Struktur Organisasi Baru
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" 
                                                       name="struktur_organisasi" 
                                                       class="custom-file-input @error('struktur_organisasi') is-invalid @enderror" 
                                                       id="struktur_organisasi"
                                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                                <label class="custom-file-label" for="struktur_organisasi">Pilih gambar...</label>
                                            </div>
                                            <small class="form-text text-muted mt-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Bagan struktur organisasi (bisa dibuat di Canva/PowerPoint)<br>
                                                <i class="fas fa-file-image mr-1"></i>
                                                Format: JPEG, PNG, WEBP<br>
                                                <i class="fas fa-weight mr-1"></i>
                                                Maksimal: 5MB<br>
                                                <i class="fas fa-expand-arrows-alt mr-1"></i>
                                                Ukuran disarankan: 1920x1080px
                                            </small>
                                            @error('struktur_organisasi')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview -->
                                        <div id="preview_struktur" class="mt-3" style="display: none;">
                                            <p class="font-weight-bold mb-2">Preview:</p>
                                            <img id="preview_struktur_img" src="" alt="Preview" class="img-fluid rounded shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-top pt-4 mt-4 d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Gambar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Custom file input label update
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

// Preview gambar header
document.getElementById('gambar_header').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_header_img').src = e.target.result;
            document.getElementById('preview_header').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Preview struktur organisasi
document.getElementById('struktur_organisasi').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_struktur_img').src = e.target.result;
            document.getElementById('preview_struktur').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>

<style>
/* Image hover effects */
.img-fluid:hover {
    transform: scale(1.02);
    transition: transform 0.3s;
}

/* Card enhancements */
.card {
    transition: all 0.3s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
}

/* Button enhancements */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}
</style>
@endpush
