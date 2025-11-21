@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        <a href="{{ route('admin.profile.show') }}" class="text-sm font-medium text-gray-700 hover:text-primary-600">
            Profile
        </a>
    </li>
    <li class="inline-flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-gray-500">Edit Profile</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white shadow-md rounded-lg border border-gray-200">
        
        <div class="border-b px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-user-edit text-primary-600"></i>
                Edit Profile
            </h2>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $admin->name) }}"
                           required
                           class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-primary-200 @error('name') border-red-500 @enderror">

                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $admin->email) }}"
                           required
                           class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-primary-200 @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button --}}
                <div class="pt-6 border-t flex items-center justify-between">
                    <a href="{{ route('admin.profile.show') }}"
                       class="px-5 py-3 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>

                    <button type="submit"
                            class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition shadow">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
