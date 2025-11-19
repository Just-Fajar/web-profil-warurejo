@extends('admin.layouts.app')

@section('title', 'Profile')

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
            <!-- Profile Info Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle text-primary mr-2"></i>
                            Informasi Profile
                        </h5>
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit mr-1"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-muted">
                            <i class="fas fa-user mr-2"></i>Nama Lengkap
                        </div>
                        <div class="col-md-8">
                            {{ $admin->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-muted">
                            <i class="fas fa-at mr-2"></i>Username
                        </div>
                        <div class="col-md-8">
                            {{ $admin->username }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-muted">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </div>
                        <div class="col-md-8">
                            {{ $admin->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold text-muted">
                            <i class="fas fa-calendar mr-2"></i>Terdaftar Sejak
                        </div>
                        <div class="col-md-8">
                            {{ $admin->created_at->format('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-lock text-warning mr-2"></i>
                        Ubah Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" 
                                   name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   required>
                            <small class="text-muted">Minimal 8 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-2"></i>
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Avatar Card -->
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold shadow-lg" style="width: 120px; height: 120px; font-size: 48px;">
                            {{ substr($admin->name, 0, 1) }}
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $admin->name }}</h5>
                    <p class="text-muted mb-3">Administrator</p>
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle mr-1"></i>
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie text-info mr-2"></i>
                        Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Terakhir Login</span>
                        <span class="font-weight-bold">Hari ini</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Login</span>
                        <span class="font-weight-bold">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
