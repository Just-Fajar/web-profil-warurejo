@extends('admin.layouts.app')

@section('title', 'Settings')

@section('breadcrumb')
<li class="inline-flex items-center">
    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Settings</span>
</li>
@endsection

@section('content')
<div class="px-4 py-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT CONTENT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Pengaturan Umum --}}
            <div class="bg-white shadow-md border rounded-xl">
                <div class="px-6 py-4 border-b">
                    <h4 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-cog text-primary-600"></i>
                        Pengaturan Umum
                    </h4>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Notifikasi --}}
                        <div class="p-4 border rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-semibold flex items-center gap-2">
                                    <i class="fas fa-bell"></i>
                                    Notifikasi
                                </p>
                                <p class="text-sm text-gray-500">
                                    Terima notifikasi untuk aktivitas penting
                                </p>
                            </div>

                            {{-- Tailwind Switch --}}
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" id="notificationSwitch" checked>
                                <div class="w-11 h-6 bg-gray-300 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:bg-primary-600 transition"></div>
                            </label>
                        </div>
                </div>
            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div class="space-y-6">

            {{-- System Info --}}
            <div class="bg-white shadow-md border rounded-xl">
                <div class="px-6 py-4 border-b">
                    <h6 class="text-md font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-info-circle text-info"></i>
                        Informasi Sistem
                    </h6>
                </div>

                <div class="p-6 space-y-4">

                    <div>
                        <p class="text-sm text-gray-500">Framework</p>
                        <p class="font-semibold">Laravel 10.x</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">PHP Version</p>
                        <p class="font-semibold">{{ phpversion() }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Environment</p>
                        <span class="px-3 py-1 rounded-lg text-white bg-green-600 text-sm">
                            {{ config('app.env') }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Debug Mode</p>
                        <span class="px-3 py-1 rounded-lg text-white text-sm 
                        {{ config('app.debug') ? 'bg-yellow-500' : 'bg-green-600' }}">
                            {{ config('app.debug') ? 'ON' : 'OFF' }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white shadow-md border rounded-xl">
                <div class="px-6 py-4 border-b">
                    <h6 class="text-md font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-500"></i>
                        Quick Actions
                    </h6>
                </div>

                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.dashboard') }}"
                       class="block text-center px-5 py-3 border rounded-lg hover:bg-blue-50 text-blue-600 border-blue-500 transition">
                        <i class="fas fa-chart-line mr-2"></i> Dashboard
                    </a>

                    <a href="{{ route('admin.profil-desa.edit') }}"
                       class="block text-center px-5 py-3 border rounded-lg hover:bg-green-50 text-green-600 border-green-500 transition">
                        <i class="fas fa-building mr-2"></i> Edit Profil Desa
                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                       class="block text-center px-5 py-3 border rounded-lg hover:bg-blue-50 text-blue-600 border-blue-500 transition">
                        <i class="fas fa-external-link-alt mr-2"></i> Lihat Website
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
