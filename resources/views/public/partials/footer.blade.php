<footer class="bg-gray-800 text-white pt-12 pb-6">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-5 items-start gap-8 mb-8">

            {{-- Kolom 1: Logo kiri pojok --}}
            <div class="flex justify-start items-center">
                <img src="{{ asset('images/Logo-Kabupaten.png') }}" 
                     alt="Logo Kabupaten Madiun" 
                     class="h-28 w-28 md:h-32 md:w-32 lg:h-36 lg:w-36 object-contain">
            </div>

            {{-- Kolom 2: Tentang --}}
            <div>
                <h3 class="text-lg font-bold mb-3">Tentang</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-primary-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <a href="https://maps.app.goo.gl/nhdvVhwMYMNMbQaH8" target="_blank" class="hover:underline">
                            Jl. Flamboyan, Templek, Warurejo, Kec. Balerejo, Kabupaten Madiun, Jawa Timur 63152
                        </a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-primary-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <a href="https://wa.me/6283114796959" target="_blank" class="hover:text-white transition">083114796959</a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-primary-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:galaxydigitalindonesia@gmail.com" class="hover:text-white transition">galaxydigitalindonesia@gmail.com</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Profil --}}
            <div>
                <h3 class="text-lg font-bold mb-3">Profil</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('profil.visi-misi') }}" class="hover:text-white transition">Visi & Misi</a></li>
                    <li><a href="{{ route('profil.sejarah') }}" class="hover:text-white transition">Sejarah</a></li>
                    <li><a href="{{ route('profil.struktur-organisasi') }}" class="hover:text-white transition">Struktur Organisasi</a></li>
                </ul>
            </div>

            {{-- Kolom 4: Informasi --}}
            <div>
                <h3 class="text-lg font-bold mb-3">Informasi</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('berita.index') }}" class="hover:text-white transition">Berita</a></li>
                    <li><a href="{{ route('potensi.index') }}" class="hover:text-white transition">Potensi</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="hover:text-white transition">Dokumentasi</a></li>
                    <li><a href="{{ route('peta-desa') }}" class="hover:text-white transition">Peta Desa</a></li>
                    <li><a href="https://wa.me/6283114796959" target="_blank" class="hover:text-white transition">Tanya Jawab & Pengaduan</a></li>
                </ul>
            </div>

            {{-- Kolom 5: Media Sosial --}}
            <div class="flex flex-col items-start md:items-end">
                <h3 class="text-lg font-bold mb-3">Media Sosial</h3>
                <div class="flex space-x-3">
                    {{-- Facebook --}}
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 bg-primary-600 text-white rounded-full flex items-center justify-center hover:bg-primary-700 transition transform hover:scale-110"
                       aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073C0 18.063 4.388 23.027 10.125 23.927v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    {{-- Instagram --}}
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 bg-primary-600 text-white rounded-full flex items-center justify-center hover:bg-primary-700 transition transform hover:scale-110"
                       aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                        </svg>
                    </a>

                    {{-- YouTube --}}
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 bg-primary-600 text-white rounded-full flex items-center justify-center hover:bg-primary-700 transition transform hover:scale-110"
                       aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>

                    {{-- TikTok --}}
                    <a href="https://www.tiktok.com/@desa.warurejo" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 bg-primary-600 text-white rounded-full flex items-center justify-center hover:bg-primary-700 transition transform hover:scale-110"
                       aria-label="TikTok">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.5 2c.4 2.6 2.2 4.5 4.7 4.7v3.2c-1.6-.1-3-.6-4.3-1.4v6.6a6 6 0 1 1-6-6c.3 0 .7 0 1 .1v3.2a3 3 0 1 0 2 2.8V2h2.6z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
            © {{ date('Y') }} Copyright. All right reserved. 
            <span>KKN-T Berdampak 24 UNIPMA</span>
        </div>
    </div>
</footer>
