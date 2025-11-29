{{--
    PUBLIC PROFIL - VISI & MISI
    
    Halaman visi dan misi Desa Warurejo
    
    FEATURES:
    - Hero section dengan primary gradient
    - Visi card: Large quote-style display
    - Misi card: Numbered list dengan icons
    - Elegant design dengan modern styling
    - Scroll reveal animations
    - Responsive layout (mobile/tablet/desktop)
    
    VISI SECTION:
    - White card dengan shadow
    - Blue gradient header
    - Eye icon (vision symbol)
    - Large italic quote text
    - Vertical blue accent line
    - Fallback message jika visi kosong
    
    MISI SECTION:
    - White card dengan shadow
    - Green gradient header
    - Target icon (mission symbol)
    - Ordered list (1, 2, 3, ...)
    - Each item dengan checkmark icon
    - Blue accent line per item
    - Fallback message jika misi kosong
    
    DESIGN ELEMENTS:
    - Glassmorphism effects
    - Gradient backgrounds
    - Icon badges dengan rounded corners
    - Smooth transitions
    - Professional typography
    
    RESPONSIVE:
    - Mobile: Full-width cards, smaller text
    - Tablet: Wider layout, medium text
    - Desktop: Max-width 5xl, large text
    
    ANIMATIONS:
    - scroll-reveal: Fade in saat scroll
    - Defined di home.blade.php atau app.css
    
    DATA:
    $profil: ProfilDesa model dengan fields:
    - visi: String - Visi desa
    - misi: Text - Misi desa (newline separated atau JSON)
    
    CONTENT MANAGEMENT:
    Edit via: /admin/profil-desa/edit
    Controller: ProfilDesaController@update
    
    Route: /profil/visi-misi
    Controller: Public\ProfilController@visiMisi
--}}
@extends('public.layouts.app')

@section('title', 'Visi & Misi - Desa Warurejo')

@section('content')

{{-- Hero Section --}}
<section class="bg-primary-700 text-white py-12 md:py-16 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-700 to-primary-800 opacity-90"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center scroll-reveal">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-wide mb-3 md:mb-4">Visi & Misi</h1>
        <p class="text-base sm:text-lg md:text-xl text-primary-100 max-w-2xl mx-auto leading-relaxed px-4">
            Visi dan Misi Desa Warurejo dalam Mewujudkan Desa Maju, Modern, dan Sejahtera.
        </p>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 sm:py-12 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        {{-- ===== VISI ===== --}}
        <div class="mb-8 sm:mb-12 md:mb-16 scroll-reveal">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-primary-700 to-primary-800 p-4 sm:p-6 md:p-7 flex items-center gap-3 sm:gap-4">
                    <div class="bg-white/20 p-3 sm:p-4 rounded-xl shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white">VISI</h2>
                        <p class="text-primary-100 text-xs sm:text-sm">Pandangan Masa Depan Desa Warurejo</p>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 sm:p-8 md:p-10">
                    @if($profil->visi)
                        <div class="flex items-start gap-5">
                            <div class="w-1 bg-primary-600 rounded-full"></div>

                            <p class="text-xl sm:text-2xl md:text-3xl font-semibold italic leading-relaxed text-gray-800">
                                "{{ $profil->visi }}"
                            </p>
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Visi belum tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== MISI ===== --}}
        <div class="mb-8 sm:mb-12 md:mb-16 scroll-reveal">
            <div class="bg-white rounded-lg md:rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-4 sm:p-6 md:p-7 flex items-center gap-3 sm:gap-4">
                    <div class="bg-white/20 p-3 sm:p-4 rounded-xl shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white">MISI</h2>
                        <p class="text-green-100 text-xs sm:text-sm">Langkah Strategis Mewujudkan Visi</p>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 sm:p-8 md:p-10">
                    @if($profil->misi && count($profil->misi_array) > 0)
                        <div class="space-y-5">

                            @foreach($profil->misi_array as $index => $misi)
                                <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-green-50 transition scroll-reveal-stagger" style="transition-delay: {{ $index * 0.1 }}s;">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                                        {{ $index + 1 }}
                                    </div>

                                    <p class="text-gray-800 text-sm sm:text-base md:text-lg leading-relaxed">
                                        {{ $misi }}
                                    </p>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center py-10 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Misi belum tersedia
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 sm:p-6 md:p-8 rounded-lg md:rounded-xl scroll-reveal">
            <h3 class="text-lg sm:text-xl font-bold text-blue-900 mb-2">Komitmen Kami</h3>
            <p class="text-sm sm:text-base text-blue-800 leading-relaxed">
                Visi dan misi ini menjadi pedoman dalam pelaksanaan pembangunan desa. Melalui kerja sama dan gotong royong, 
                kami berkomitmen mewujudkan Desa Warurejo yang lebih maju, mandiri, dan sejahtera.
            </p>
        </div>

        {{-- Navigation --}}
        <div class="mt-8 sm:mt-12 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 scroll-reveal">

            {{-- Sejarah --}}
            <a href="{{ route('profil.sejarah') }}" class="group bg-white rounded-lg md:rounded-xl shadow-md p-4 sm:p-6 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="bg-green-100 group-hover:bg-green-200 p-2.5 sm:p-3 rounded-full transition shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-semibold text-gray-800 text-base sm:text-lg group-hover:text-green-600 transition truncate">Sejarah Desa</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Lihat sejarah desa</p>
                    </div>
                </div>
            </a>

            {{-- Struktur --}}
            <a href="{{ route('profil.struktur-organisasi') }}" class="group bg-white rounded-lg md:rounded-xl shadow-md p-4 sm:p-6 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="bg-green-100 group-hover:bg-green-200 p-2.5 sm:p-3 rounded-full transition shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-semibold text-gray-800 text-base sm:text-lg group-hover:text-green-600 transition truncate">Struktur Organisasi</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Lihat struktur organisasi</p>
                    </div>
                </div>
            </a>

        </div>

    </div>
</section>

<style>
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

.scroll-reveal-stagger {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.scroll-reveal-stagger.revealed {
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
    document.querySelectorAll('.scroll-reveal, .scroll-reveal-stagger').forEach(el => {
        observer.observe(el);
    });
});
</script>

@endsection
