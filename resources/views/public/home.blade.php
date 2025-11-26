@extends('public.layouts.app')

@section('title', 'Beranda')

@section('content')


<!-- Hero + Navbar dalam satu section -->
<section 
    class="relative flex flex-col justify-center items-center bg-cover bg-center bg-no-repeat min-h-screen text-white" 
    style="background-image: url('{{ asset('images/logo-web-desa.jpg') }}');"
>

    
    <!-- Overlay agar teks dan navbar kontras -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Navbar dimasukkan di sini -->
<div class="absolute top-0 left-0 w-full z-20">
    @include('public.partials.navbar')
</div>


    <!-- Hero Text -->
    <div class="relative z-10 container mx-auto px-4 py-24 text-center text-white scroll-reveal">
        
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Selamat Datang di Website Resmi {{ $profil->nama_desa }}
        </h1>
        <h1 class="text-lg md:text-xl text-white">
            Kecamatan Balerejo, Kabupaten Madiun
        </h1>
    </div>
</section>

<!-- Stats Section Animated -->
<section class="py-16 bg-white"
style="background-image: url('{{ asset('images/bg2.jpg') }}');">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            <!-- Item -->
            <div class="group text-center p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 scroll-reveal-stagger delay-100">
                <div class="flex justify-center mb-3">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="10" fill="#E8F5E9"/>
<path d="M10 32L24 18L38 32H10Z" fill="#81C784"/>
<path d="M18 32V24H30V32" fill="#4CAF50"/>
<path d="M21 32V27H27V32" fill="#2E7D32"/>
<circle cx="34" cy="18" r="5" fill="#66BB6A"/>
<circle cx="14" cy="20" r="3" fill="#A5D6A7"/>
</svg>

                </div>
                <div class="text-4xl font-bold text-primary-600 mb-1 count" data-target="{{ $totalPotensi }}">0</div>
                <div class="text-gray-600">Potensi Desa</div>
            </div>

            <div class="group text-center p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 scroll-reveal-stagger delay-200">
                <div class="flex justify-center mb-3">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="10" fill="#E3F2FD"/>
<rect x="10" y="12" width="28" height="24" rx="3" fill="white" stroke="#64B5F6" stroke-width="2"/>
<rect x="14" y="16" width="10" height="8" fill="#90CAF9"/>
<rect x="26" y="16" width="10" height="2" fill="#BBDEFB"/>
<rect x="26" y="20" width="10" height="2" fill="#BBDEFB"/>
<rect x="14" y="27" width="22" height="2" fill="#90CAF9"/>
<rect x="14" y="31" width="22" height="2" fill="#90CAF9"/>
</svg>

                </div>
                <div class="text-4xl font-bold text-primary-600 mb-1 count" data-target="{{ $totalBerita }}">0</div>
                <div class="text-gray-600">Berita Terbaru</div>
            </div>

            <div class="group text-center p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 scroll-reveal-stagger delay-300">
                <div class="flex justify-center mb-3">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="10" fill="#FFF3E0"/>
<rect x="10" y="16" width="28" height="20" rx="4" fill="#FFB74D"/>
<circle cx="24" cy="26" r="7" fill="#FFF"/>
<circle cx="24" cy="26" r="4" fill="#FF9800"/>
<rect x="18" y="12" width="12" height="6" rx="2" fill="#F57C00"/>
</svg>

                </div>
                <div class="text-4xl font-bold text-primary-600 mb-1 count" data-target="{{ $totalGaleri }}">0</div>
                <div class="text-gray-600">Dokumentasi</div>
            </div>

            <div class="group text-center p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 scroll-reveal-stagger delay-400">
                <div class="flex justify-center mb-3">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="10" fill="#EDE7F6"/>
<circle cx="24" cy="18" r="7" fill="#9575CD"/>
<path d="M12 36C12 28 19 26 24 26C29 26 36 28 36 36" fill="#B39DDB"/>
</svg>

                </div>
                <div class="text-4xl font-bold text-primary-600 mb-1 count" data-target="{{ $totalVisitors }}">0</div>
                <div class="text-gray-600">Pengunjung</div>
            </div>

        </div>
    </div>
</section>


                <!-- Sambutan Kepala Desa -->
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <div class="text-center mb-12 scroll-reveal">
                            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-2">Selamat Datang</h2>
                        </div>

                        <div class="max-w-7xl mx-auto">
                            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 items-start">
                                
                                <!-- Photo (Mobile: Top, Desktop: Right) -->
                                <div class="lg:col-span-2 order-1 lg:order-2 scroll-reveal-right">
                                    <div class="relative h-full max-w-sm mx-auto lg:max-w-none">
                                        <!-- Yellow Corner Decorations -->
                                        <div class="absolute top-0 right-0 w-12 h-12 border-t-4 border-r-4 border-amber-400 rounded-tr-2xl"></div>
                                        <div class="absolute bottom-0 left-0 w-12 h-12 border-b-4 border-l-4 border-amber-400 rounded-bl-2xl"></div>
                                        
                                        <!-- Photo Container -->
                                        <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-2xl h-full min-h-[350px] lg:min-h-[450px] mt-6 mb-6 lg:mt-0 lg:mb-0">
                                            <img 
                    src="{{ asset('images/pemandangan-alam.jpg') }}" 
                    alt="Kepala Desa {{ $profil->nama_desa }}"
                    class="max-w-xs md:max-w-sm lg:max-w-md h-auto mx-auto object-contain"
                    loading="lazy"
                    decoding="async"
                >

                                        </div>
                                    </div>
                                </div>

                <!-- Text Content (Mobile: Bottom, Desktop: Left) -->
                <div class="lg:col-span-3 order-2 lg:order-1 scroll-reveal-left">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-primary-700 mb-4 text-center lg:text-left">
                        SAMBUTAN KEPALA {{ strtoupper($profil->nama_desa) }}
                    </h3>
                    <div class="w-20 h-1 bg-amber-400 mb-6 mx-auto lg:mx-0"></div>
                    
                    <div class="text-gray-700 space-y-4 text-justify leading-relaxed text-sm md:text-base">
                        <p class="font-medium">Assalamu'alaikum warahmatullahi wabarakatuh,</p>
                        <p>Salam sejahtera bagi kita semua,</p>
                        <p>
                            Dengan penuh rasa syukur, saya menyambut seluruh warga dan pengunjung di website resmi Desa {{ $profil->nama_desa }}. 
                            Website ini kami hadirkan sebagai wujud keterbukaan informasi dan upaya dalam memajukan desa menuju kemandirian berbasis teknologi.
                        </p>
                        <p>
                            Sebagai Kepala Desa, saya bersama seluruh perangkat desa berkomitmen untuk membangun Desa {{ $profil->nama_desa }} yang mandiri, maju, dan berdaya saing dengan memanfaatkan teknologi sebagai pilar utama pembangunan.
                        </p>
                        <p>
                            Melalui platform ini, kami berharap dapat memberikan kemudahan akses informasi, pelayanan yang lebih baik, serta menjadi jembatan komunikasi antara pemerintah desa dan masyarakat. 
                            Mari bersama-sama membangun desa yang lebih maju, sejahtera, dan berdaya saing di era digital ini.
                        </p>
                        <p class="font-medium">Wassalamu'alaikum warahmatullahi wabarakatuh.</p>
                        
                        <div class="mt-8">
                            <p class="text-lg md:text-xl font-bold text-gray-800">{{ strtoupper($profil->nama_kepala_desa ?? 'Sunarto') }}</p>
                            <p class="text-gray-600">Kepala {{ $profil->nama_desa }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ============================
     P O T E N S I   D E S A
============================= --}}
<section class="py-16 bg-white content-section">
    <div class="container mx-auto px-4 main-content">

        <div class="text-center mb-12 section-header scroll-reveal">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 section-title">Potensi Desa</h2>
            <p class="text-gray-600 section-subtitle">Kekayaan dan potensi yang dimiliki {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 card-grid content-grid">
            @forelse($potensi->take(3) as $item)

                {{-- CARD KLIKABLE DENGAN ENHANCED EFFECTS --}}
                <a href="{{ route('potensi.show', $item->slug) }}"
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group block scroll-reveal-stagger">

                    {{-- Gambar dengan Hover Zoom --}}
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->gambar) }}"
                             alt="{{ $item->nama_potensi }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy"
                             decoding="async">
                    </div>

                    {{-- Konten --}}
                    <div class="p-6">
                        {{-- Tanggal dan Views --}}
                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-3">
                            <span class="flex items-center gap-1"
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($item->views) }}
                            </span>
                        </div>

                        {{-- Nama Potensi --}}
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                            {{ $item->nama }}
                        </h3>

                        {{-- Deskripsi Singkat --}}
                        <p class="text-gray-600 line-height-relaxed line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($item->deskripsi), 120) }}
                        </p>

                        {{-- Read More Button --}}
                        <div class="mt-4">
                            <span class="inline-flex items-center gap-2 text-primary-600 font-semibold text-sm hover:text-primary-700 transition-colors">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada data potensi</p>
                </div>
            @endforelse
        </div>

        @if($potensi->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('potensi.index') }}" 
                   class="inline-flex items-center gap-2 bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    Lihat Semua Potensi
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif

    </div>
</section>



{{-- ============================
      B E R I T A   T E R K I N I
============================= --}}
<section class="py-16 bg-gray-50 content-section">
    <div class="container mx-auto px-4 main-content">

        <div class="text-center mb-12 section-header scroll-reveal">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 section-title">Berita Terkini</h2>
            <p class="text-gray-600 section-subtitle">Informasi dan kabar terbaru dari {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 card-grid content-grid">
            @forelse($latest_berita as $berita)
                
                {{-- CARD KLIKABLE DENGAN ENHANCED EFFECTS --}}
                <a href="{{ route('berita.show', $berita->slug) }}"
                   class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group block scroll-reveal-stagger">

                    {{-- Gambar dengan Hover Zoom --}}
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $berita->gambar_utama_url }}" 
                             alt="{{ $berita->judul }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy"
                             decoding="async">
                    </div>

                    {{-- Konten --}}
                    <div class="p-6">
                        {{-- Tanggal dan Views --}}
                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-3">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $berita->published_at?->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($berita->views) }}
                            </span>
                        </div>

                        {{-- Judul Berita --}}
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                            {{ $berita->judul }}
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-gray-600 line-height-relaxed line-clamp-3 mb-4">
                            {{ $berita->excerpt }}
                        </p>

                        {{-- Read More Button --}}
                        <div class="mt-4">
                            <span class="inline-flex items-center gap-2 text-primary-600 font-semibold text-sm hover:text-primary-700 transition-colors">
                                Baca Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>

        @if($latest_berita->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('berita.index') }}" 
                   class="inline-flex items-center gap-2 bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    Lihat Semua Berita
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif

    </div>
</section>


<!-- Gallery Preview -->
<section class="py-16 bg-gray-50 content-section">
    <div class="container mx-auto px-4 main-content">
        <div class="text-center mb-12 section-header scroll-reveal">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 section-title">Galeri</h2>
            <p class="text-gray-600 section-subtitle">Dokumentasi kegiatan dan momen penting di {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 card-grid content-grid">
    @forelse($galeri as $item)
        <div 
            onclick="openImageModal('{{ $item->gambar_url }}')" 
            class="bg-white group relative overflow-hidden cursor-pointer rounded-lg shadow-md hover:shadow-xl transition-all duration-300 scroll-reveal-stagger"
        >
            {{-- Image with Zoom Effect --}}
            <div class="aspect-video overflow-hidden">
                <img src="{{ $item->gambar_url }}" 
                     alt="{{ $item->judul }}" 
                     class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                     loading="lazy"
                     decoding="async">
            </div>
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-linear-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                <h3 class="text-white font-semibold text-sm mb-1">{{ $item->judul }}</h3>
                <div class="flex items-center gap-3 text-white/80 text-xs">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $item->formatted_date }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($item->views) }}
                    </span>
                </div>
            </div>
        </div>
    @empty

                <div class="col-span-3 text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada dokumentasi</p>
                </div>
            @endforelse
        </div>

        @if($galeri->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('galeri.index') }}" 
                   class="inline-flex items-center gap-2 bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    Lihat Semua Galeri
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
    <!-- Image Modal -->
<div id="imageModal" 
     class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="relative max-w-4xl w-full mx-4">
        <button onclick="closeImageModal()" 
                class="absolute -top-10 right-0 text-white text-3xl font-bold hover:text-gray-300">
            &times;
        </button>

        <img id="modalImage" src="" 
             class="w-full max-h-[80vh] object-contain rounded-lg shadow-lg">
    </div>
</div>

</section>

<style>
/* Navbar slide-down animation */
.navbar-slide-down {
    animation: slideDown 0.8s ease-out;
}

@keyframes slideDown {
    0% {
        opacity: 0;
        transform: translateY(-100%);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scroll-triggered animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.scroll-reveal-left {
    opacity: 0;
    transform: translateX(-50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal-left.revealed {
    opacity: 1;
    transform: translateX(0);
}

.scroll-reveal-right {
    opacity: 0;
    transform: translateX(50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal-right.revealed {
    opacity: 1;
    transform: translateX(0);
}

.scroll-reveal-stagger {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.scroll-reveal-stagger.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Delay classes for stagger effect */
.delay-100 { transition-delay: 0.1s; }
.delay-200 { transition-delay: 0.2s; }
.delay-300 { transition-delay: 0.3s; }
.delay-400 { transition-delay: 0.4s; }
.delay-500 { transition-delay: 0.5s; }
.delay-600 { transition-delay: 0.6s; }

/* Footer animation */
.scroll-reveal-footer {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal-footer.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
// Scroll-triggered animation observer
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-reveal classes
    document.querySelectorAll('.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right, .scroll-reveal-stagger, .scroll-reveal-footer').forEach(el => {
        observer.observe(el);
    });

    // Counter animation for stats
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                const target = +entry.target.getAttribute("data-target");
                let count = 0;

                const update = () => {
                    const speed = 40;
                    if (count < target) {
                        count += Math.ceil(target / 40);
                        entry.target.textContent = count;
                        requestAnimationFrame(update);
                    } else {
                        entry.target.textContent = target.toLocaleString();
                    }
                };
                update();
            }
        });
    }, observerOptions);

    document.querySelectorAll('.count').forEach(el => {
        counterObserver.observe(el);
    });
});
</script>

<script>
function openImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    modalImage.src = imageUrl;
    modal.classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Tutup modal jika klik area gelap
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) closeImageModal();
});
</script>

@endsection