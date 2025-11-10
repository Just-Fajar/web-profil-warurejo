<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Desa Warurejo</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-primary-600 text-white">
                    <h1 class="text-xl font-bold">Admin Desa Warurejo</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.profil-desa.edit') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.profil-desa.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Profil Desa</span>
                    </a>

                    <a href="{{ route('admin.berita.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.berita.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('admin.potensi-desa.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.potensi-desa.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Potensi Desa</span>
                    </a>

                    <a href="{{ route('admin.galeri.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.galeri.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Galeri</span>
                    </a>

                    <a href="{{ route('admin.pengaturan.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <span>Pengaturan</span>
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="border-t p-4">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold">
                            {{ substr(auth()->guard('admin')->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold">Admin Panel</h1>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>