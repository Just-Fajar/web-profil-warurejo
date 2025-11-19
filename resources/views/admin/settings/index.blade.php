@extends('admin.layouts.app')

@section('title', 'Settings')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-gray-500
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- General Settings -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-cog text-primary mr-2"></i>
                        Pengaturan Umum
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Notifications Setting -->
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-bell mr-2"></i>
                                        Notifikasi
                                    </h6>
                                    <small class="text-muted">Terima notifikasi untuk aktivitas penting</small>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="notificationSwitch" checked>
                                    <label class="custom-control-label" for="notificationSwitch"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Language Setting -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                <i class="fas fa-language mr-2"></i>
                                Bahasa
                            </label>
                            <select class="form-control" name="language">
                                <option value="id" selected>Bahasa Indonesia</option>
                                <option value="en" disabled>English (Coming Soon)</option>
                            </select>
                        </div>

                        <!-- Timezone Setting -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                <i class="fas fa-clock mr-2"></i>
                                Zona Waktu
                            </label>
                            <select class="form-control" name="timezone">
                                <option value="Asia/Jakarta" selected>WIB - Jakarta</option>
                                <option value="Asia/Makassar">WITA - Makassar</option>
                                <option value="Asia/Jayapura">WIT - Jayapura</option>
                            </select>
                        </div>

                        <div class="border-top pt-4 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-tools text-warning mr-2"></i>
                        Mode Maintenance
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian:</strong> Mode maintenance akan membuat website tidak dapat diakses oleh pengunjung.
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                        <div>
                            <h6 class="mb-1">Aktifkan Mode Maintenance</h6>
                            <small class="text-muted">Website akan menampilkan halaman "Under Maintenance"</small>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="maintenanceSwitch">
                            <label class="custom-control-label" for="maintenanceSwitch"></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cache Management -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-database text-info mr-2"></i>
                        Cache Management
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Bersihkan cache untuk memperbarui data dan meningkatkan performa website.
                    </p>
                    <button type="button" class="btn btn-outline-danger" onclick="alert('Fitur ini akan segera tersedia!')">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Clear All Cache
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- System Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle text-info mr-2"></i>
                        Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Framework</small>
                        <p class="mb-0 font-weight-bold">Laravel 12.x</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">PHP Version</small>
                        <p class="mb-0 font-weight-bold">{{ phpversion() }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Environment</small>
                        <p class="mb-0">
                            <span class="badge badge-success">{{ config('app.env') }}</span>
                        </p>
                    </div>
                    <div>
                        <small class="text-muted">Debug Mode</small>
                        <p class="mb-0">
                            <span class="badge {{ config('app.debug') ? 'badge-warning' : 'badge-success' }}">
                                {{ config('app.debug') ? 'ON' : 'OFF' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt text-warning mr-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-chart-line mr-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.profil-desa.edit') }}" class="btn btn-outline-success btn-block mb-2">
                        <i class="fas fa-building mr-2"></i>
                        Edit Profil Desa
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-info btn-block">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Lihat Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Settings page scripts
</script>
@endpush

