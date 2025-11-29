{{--
    PUBLIC PROFIL - SEJARAH DESA
    
    Halaman sejarah dan perkembangan Desa Warurejo
    
    FEATURES:
    - Hero section dengan primary gradient
    - Timeline-style content layout
    - Rich text sejarah dengan formatting
    - Historical icons (calendar, clock)
    - Scroll reveal animations
    - Responsive design
    
    SEJARAH SECTION:
    - White card dengan shadow
    - Amber gradient header (historical theme)
    - Calendar icon (time symbol)
    - Timeline vertical line (amber accent)
    - Rich HTML content dari TinyMCE
    - Support images, lists, formatted text
    - Fallback message jika sejarah kosong
    
    DESIGN ELEMENTS:
    - Timeline layout dengan vertical line
    - Clock icon untuk "Awal Mula" section
    - Amber color scheme (historical feel)
    - Professional typography
    - Image support dalam content
    
    TIMELINE STYLE:
    - Vertical amber line di left side
    - Clock icon di top
    - Content dengan proper spacing
    - "Awal Mula" heading
    
    CONTENT RENDERING:
    - {!! $profil->sejarah !!} - Raw HTML
    - Already sanitized di ProfilDesaController
    - Full HTML support dari TinyMCE editor
    - Images, tables, lists supported
    
    RESPONSIVE:
    - Mobile: Full-width, smaller timeline
    - Tablet: Wider layout, medium spacing
    - Desktop: Max-width 5xl, full timeline
    
    ANIMATIONS:
    - scroll-reveal: Fade in effect
    - Smooth entrance transitions
    
    DATA:
    $profil: ProfilDesa model dengan field:
    - sejarah: Text/LongText - HTML content
    
    CONTENT MANAGEMENT:
    Edit via: /admin/profil-desa/edit
    TinyMCE editor untuk rich text
    Controller: ProfilDesaController@update
    
    Route: /profil/sejarah
    Controller: Public\ProfilController@sejarah
--}}
@extends('public.layouts.app')

@section('title', 'Sejarah Desa - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center scroll-reveal">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Sejarah Desa</h1>
            <p class="text-lg text-primary-100">
                Perjalanan Sejarah dan Perkembangan Desa Warurejo dari Masa ke Masa
            </p>
        </div>
    </div>
</section>

{{-- Sejarah Content --}}
<section class="py-8 sm:py-12 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            
            {{-- Sejarah Section --}}
            <div class="mb-8 sm:mb-12 md:mb-16 scroll-reveal">
                <div class="bg-white rounded-lg md:rounded-xl shadow-xl overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-linear-to-r from-amber-600 to-amber-700 p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-full p-3 sm:p-4 mr-3 sm:mr-4 shrink-0">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-white">SEJARAH DESA WARUREJO</h2>
                                <p class="text-amber-100 text-xs sm:text-sm">Jejak Perjalanan dan Perkembangan</p>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4 sm:p-6 md:p-8">
                        @if($profil->sejarah)
                            <div class="prose prose-lg max-w-none">
                                {{-- Timeline Icon --}}
                                <div class="flex items-start mb-6">
                                    <div class="shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Awal Mula</h3>
                                    </div>
                                </div>

                                {{-- Sejarah Text dengan styling --}}
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-amber-200"></div>
                                    
                                    <div class="text-sm sm:text-base text-gray-700 leading-relaxed space-y-3 sm:space-y-4">
                                        {!! nl2br(e($profil->sejarah)) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-500 text-lg">Sejarah desa belum tersedia</p>
                                <p class="text-gray-400 text-sm mt-2">Silakan hubungi admin untuk informasi lebih lanjut</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Box Tambahan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-8 sm:mb-12 scroll-reveal">
                {{-- Warisan Budaya --}}
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-t-4 border-purple-500">
                    <div class="flex items-start">
                        <div class="bg-purple-100 rounded-full p-2.5 sm:p-3 mr-3 sm:mr-4 shrink-0">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2 text-base sm:text-lg">Warisan Budaya</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">
                                Desa Warurejo memiliki kekayaan budaya dan tradisi yang terus dilestarikan dari generasi ke generasi.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Perkembangan --}}
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-t-4 border-green-500">
                    <div class="flex items-start">
                        <div class="bg-green-100 rounded-full p-2.5 sm:p-3 mr-3 sm:mr-4 shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2 text-base sm:text-lg">Perkembangan</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">
                                Seiring waktu, Desa Warurejo terus berkembang menuju desa yang lebih maju dan modern.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quote Box --}}
            <div class="bg-linear-to-r from-blue-600 to-blue-700 rounded-lg md:rounded-xl shadow-xl p-4 sm:p-6 md:p-8 mb-8 sm:mb-12 text-white scroll-reveal">
                <div class="flex items-start">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-blue-300 mr-3 sm:mr-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-lg sm:text-xl md:text-2xl leading-relaxed italic mb-3 sm:mb-4">
                            "Mengenal sejarah adalah menghargai perjalanan. Dengan memahami masa lalu, kita dapat membangun masa depan yang lebih baik."
                        </p>
                        <p class="text-blue-200 font-semibold">- Pepatah Desa Warurejo</p>
                    </div>
                </div>
            </div>

            {{-- Navigation Links --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 scroll-reveal">
                <a href="{{ route('profil.visi-misi') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-4 sm:p-6 border-t-4 border-primary-600">
                    <div class="flex items-center">
                        <div class="bg-primary-100 rounded-full p-2.5 sm:p-3 mr-3 sm:mr-4 group-hover:bg-primary-200 transition shrink-0">
                            <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 group-hover:text-primary-600 transition truncate">Visi & Misi</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Lihat visi dan misi desa</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profil.struktur-organisasi') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-4 sm:p-6 border-t-4 border-green-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-2.5 sm:p-3 mr-3 sm:mr-4 group-hover:bg-green-200 transition shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 group-hover:text-green-600 transition truncate">Struktur Organisasi</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Lihat struktur organisasi desa</p>
                        </div>
                    </div>
                </a>
            </div>

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
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
});
</script>

@endsection