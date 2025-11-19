<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Desa Warurejo</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false, loading: false }">
    
    <!-- Loading Overlay -->
    <div x-show="loading" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
         style="display: none;">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-12 w-12 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-4 text-gray-700 font-medium">Loading...</p>
            </div>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
                    <i class="fas fa-home-lg-alt text-2xl mr-2"></i>
                    <h1 class="text-xl font-bold">Admin Warurejo</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.berita.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.berita.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-newspaper w-5 mr-3"></i>
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('admin.potensi.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.potensi.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-seedling w-5 mr-3"></i>
                        <span>Potensi Desa</span>
                    </a>

                    <a href="{{ route('admin.galeri.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.galeri.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-images w-5 mr-3"></i>
                        <span>Galeri</span>
                    </a>

                    <div class="border-t border-gray-200 my-2"></div>

                    <a href="{{ route('admin.profil-desa.edit') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.profil-desa.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-building w-5 mr-3"></i>
                        <span>Profil Desa</span>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="border-t border-gray-200 p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ substr(auth()->guard('admin')->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-700 auth()->guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-500
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm text-center text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 lg:px-6 py-3">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <div class="flex-1">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600
                                        <i class="fas fa-home mr-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                @hasSection('breadcrumb')
                                    @yield('breadcrumb')
                                @endif
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Desktop User Dropdown -->
                    <div class="hidden lg:block" x-data="{ dropdownOpen: false }">
                        <div class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" 
                                    class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ substr(auth()->guard('admin')->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium">{{ auth()->guard('admin')->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen" 
                                 @click.away="dropdownOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200
                                 style="display: none;">
                                <a href="{{ route('admin.profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100
                                    <i class="fas fa-user-circle w-5 mr-3"></i>
                                    Profile
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100
                                    <i class="fas fa-cog w-5 mr-3"></i>
                                    Settings
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100
                                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
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
