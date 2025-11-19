@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        <a href="{{ route('admin.profile.show') }}" class="text-sm font-medium text-gray-700 hover:text-primary-600">Profile</a>
    </li>
    <li class="inline-flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-gray-500
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit text-primary mr-2"></i>
                        Edit Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $admin->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="username" 
                                   class="form-control form-control-lg @error('username') is-invalid @enderror" 
                                   value="{{ old('username', $admin->username) }}" 
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $admin->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="border-top pt-4 mt-4 d-flex justify-content-between">
                            <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
