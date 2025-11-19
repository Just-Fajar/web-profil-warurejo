<nav 
    x-data="{ mobileMenuOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
    :class="scrolled ? 'bg-white shadow-md' : 'bg-transparent backdrop-blur-md'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500"
>

    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo dan Judul -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/Logo-Kabupaten.png') }}" alt="Logo Desa" class="h-12 w-12">
                <div>
                    <h1 :class="scrolled ? 'text-gray-800' : 'text-white'" class="text-xl font-bold transition-colors duration-300">Desa Warurejo</h1>
                    <p :class="scrolled ? 'text-gray-600' : 'text-green-100'" class="text-xs transition-colors duration-300">Kabupaten Madiun</p>
                </div>
            </a>

            <!-- Menu Desktop -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" :class="scrolled ? 'text-gray-700 hover:text-green-600' : 'text-white hover:text-green-200'" class="font-medium transition-colors duration-300 {{ request()->routeIs('home') ? 'font-bold' : '' }}">
                    Beranda
                </a>

                <!-- Dropdown Profil -->
                <div class="relative group">
                    <button :class="scrolled ? 'text-gray-700 hover:text-green-600' : 'text-white hover:text-green-200'" class="font-medium transition-colors duration-300 flex items-center {{ request()->routeIs('profil.*') ? 'font-bold' : '' }}">
                        Profil
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Visi & Misi</a>
                        <a href="{{ route('profil.sejarah') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Sejarah</a>
                        <a href="{{ route('profil.struktur-organisasi') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Struktur Organisasi</a>
                    </div>
                </div>

                <!-- Dropdown Informasi -->
                <div class="relative group">
                    <button :class="scrolled ? 'text-gray-700 hover:text-green-600' : 'text-white hover:text-green-200'" class="font-medium transition-colors duration-300 flex items-center">
                        Informasi
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('berita.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Berita</a>
                        <a href="{{ route('potensi.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Potensi</a>
                        <a href="{{ route('galeri.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Dokumentasi</a>
                        <a href="{{ route('peta-desa') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Peta Desa</a>
                        <a href="https://wa.me/6283114796959" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Tanya Jawab & Pengaduan</a>
                    </div>
                </div>

                <!-- Dropdown Publikasi -->
                <div class="relative group">
                    <button :class="scrolled ? 'text-gray-700 hover:text-green-600' : 'text-white hover:text-green-200'" class="font-medium transition-colors duration-300 flex items-center">
                        Publikasi
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">APBDes</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">RPJMDes</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">RKPDes</a>
                    </div>
                </div>
            </div>

            <!-- Tombol Mobile -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" :class="scrolled ? 'text-gray-700' : 'text-white'" class="md:hidden transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Menu Mobile -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4 bg-white rounded-lg mt-2 shadow-md">
            <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-primary-600 font-medium px-4">Beranda</a>
            
            <div class="pl-2">
                <p class="py-2 text-gray-700 font-semibold px-4">Profil</p>
                <a href="{{ route('profil.visi-misi') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Visi & Misi</a>
                <a href="{{ route('profil.sejarah') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Sejarah</a>
                <a href="{{ route('profil.struktur-organisasi') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Struktur Organisasi</a>
            </div>

            <div class="pl-2 mt-2">
                <p class="py-2 text-gray-700 font-semibold px-4">Informasi & Lainnya</p>
                <a href="{{ route('berita.index') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Berita</a>
                <a href="{{ route('potensi.index') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Potensi</a>
                <a href="{{ route('galeri.index') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Dokumentasi</a>
                <a href="{{ route('peta-desa') }}" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Peta Desa</a>
                <a href="https://wa.me/6283114796959" class="block py-2 px-6 text-gray-700 hover:text-primary-600">Tanya Jawab & Pengaduan</a>
            </div>

            <div class="pl-2 mt-2">
                <p class="py-2 text-gray-700 font-semibold px-4">Publikasi</p>
                <a href="#" class="block py-2 px-6 text-gray-700 hover:text-primary-600">APBDes</a>
                <a href="#" class="block py-2 px-6 text-gray-700 hover:text-primary-600">RPJMDes</a>
                <a href="#" class="block py-2 px-6 text-gray-700 hover:text-primary-600">RKPDes</a>            </div>
        </div>
    </div>
</nav>
