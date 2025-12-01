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
                        <div class="space-y-8 sm:space-y-10 md:space-y-12">
                            
                            {{-- 1. Asal Usul Nama dan Pembentukan --}}
                            <div class="scroll-reveal">
                                <div class="flex items-start mb-4">
                                    <div class="shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Asal Usul Nama dan Pembentukan</h3>
                                    </div>
                                </div>
                                
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-amber-200"></div>
                                    
                                    <div class="space-y-4 text-sm sm:text-base text-gray-700 leading-relaxed">
                                        <p>Nama desa <strong class="text-amber-700">Warurejo</strong> kemungkinan besar berasal dari kombinasi dua kata dalam bahasa Jawa:</p>
                                        
                                        <div class="bg-amber-50 rounded-lg p-4 space-y-3 border-l-4 border-amber-400">
                                            <div>
                                                <span class="font-bold text-amber-800">Waru:</span>
                                                <span class="ml-2">Merujuk pada Pohon Waru (<em>Hibiscus tiliaceus</em>) yang mungkin dahulu banyak tumbuh atau menjadi penanda wilayah. Pohon Waru sering dikaitkan dengan tempat teduh dan pertemuan.</span>
                                            </div>
                                            <div>
                                                <span class="font-bold text-amber-800">Rejo:</span>
                                                <span class="ml-2">Memiliki arti ramai, makmur, atau subur.</span>
                                            </div>
                                        </div>
                                        
                                        <p class="italic text-amber-900 bg-amber-50 p-4 rounded-lg border border-amber-200">
                                            Dengan demikian, <strong>Warurejo</strong> dapat diartikan sebagai <strong>"Tempat yang ramai/makmur yang ditandai dengan adanya Pohon Waru"</strong> atau <strong>"Kawasan yang dibuka menjadi subur di mana pohon waru banyak ditemukan"</strong>.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. Periode Awal dan Pembukaan Lahan --}}
                            <div class="scroll-reveal">
                                <div class="flex items-start mb-4">
                                    <div class="shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Periode Awal dan Pembukaan Lahan</h3>
                                    </div>
                                </div>
                                
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-green-200"></div>
                                    
                                    <div class="space-y-4 text-sm sm:text-base text-gray-700 leading-relaxed">
                                        <p>Seperti desa-desa di sekitar Balerejo (yang dikenal sebagai daerah dataran rendah dan persawahan yang subur), Warurejo diperkirakan dibuka pada masa-masa:</p>
                                        
                                        <div class="space-y-3">
                                            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-400">
                                                <h4 class="font-bold text-green-800 mb-2">Masa Kerajaan Mataram Islam</h4>
                                                <p>Ketika pengaruh Mataram meluas ke wilayah timur, terjadi pembukaan lahan baru untuk pemukiman dan pertanian.</p>
                                            </div>
                                            
                                            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-400">
                                                <h4 class="font-bold text-green-800 mb-2">Awal Kolonial</h4>
                                                <p>Pembukaan lahan semakin intensif seiring kebutuhan komoditas pertanian.</p>
                                            </div>
                                        </div>
                                        
                                        <p>Penduduk pertama Warurejo kemungkinan besar adalah para pendatang atau kelompok yang diutus untuk membuka hutan (atau <em>babat alas</em>) menjadi lahan sawah dan tempat tinggal. Mereka mencari lokasi yang dekat dengan sumber air, yang di wilayah Balerejo banyak dilintasi oleh anak-anak Sungai Madiun.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- 3. Perkembangan Masa Kolonial hingga Kemerdekaan --}}
                            <div class="scroll-reveal">
                                <div class="flex items-start mb-4">
                                    <div class="shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Perkembangan Masa Kolonial hingga Kemerdekaan</h3>
                                    </div>
                                </div>
                                
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                                    
                                    <div class="space-y-4 text-sm sm:text-base text-gray-700 leading-relaxed">
                                        <div class="space-y-3">
                                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
                                                <h4 class="font-bold text-blue-800 mb-2">Basis Pertanian</h4>
                                                <p>Wilayah Warurejo dan sekitarnya berkembang menjadi basis utama pertanian, terutama padi.</p>
                                            </div>
                                            
                                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
                                                <h4 class="font-bold text-blue-800 mb-2">Organisasi Pemerintahan</h4>
                                                <p>Pembentukan struktur desa modern dimulai pada masa Kolonial Belanda (periode <em>Inlandsche Gemeente Ordonnantie</em>), di mana batas-batas desa mulai diresmikan dan pemimpin desa (Kepala Desa/Lurah) mulai ditunjuk atau dipilih.</p>
                                            </div>
                                            
                                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
                                                <h4 class="font-bold text-blue-800 mb-2">Peristiwa Madiun</h4>
                                                <p>Sebagai bagian dari Kabupaten Madiun, desa ini kemungkinan juga merasakan dampak dari peristiwa-peristiwa penting di sekitar tahun 1948, termasuk mobilisasi penduduk atau pergerakan militer.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 4. Perkembangan Perekonomian dan Sosial --}}
                            <div class="scroll-reveal">
                                <div class="flex items-start mb-4">
                                    <div class="shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Perkembangan Perekonomian dan Sosial</h3>
                                    </div>
                                </div>
                                
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-purple-200"></div>
                                    
                                    <div class="space-y-4 text-sm sm:text-base text-gray-700 leading-relaxed">
                                        <p>Hingga kini, Desa Warurejo memiliki ciri-ciri umum desa di Madiun:</p>
                                        
                                        <div class="space-y-3">
                                            <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-400">
                                                <h4 class="font-bold text-purple-800 mb-2">Ekonomi</h4>
                                                <p>Mayoritas penduduk bergerak di sektor pertanian atau jasa/buruh.</p>
                                            </div>
                                            
                                            <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-400">
                                                <h4 class="font-bold text-purple-800 mb-2">Sosial</h4>
                                                <p>Komunitas yang erat, dengan nilai-nilai gotong royong yang kuat (sesuai dengan kata "Rejo" yang mencerminkan kemakmuran dan keramaian kolektif).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 5. Para Pendiri Desa Warurejo --}}
                            <div class="scroll-reveal">
                                <div class="flex items-start mb-4">
                                    <div class="shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Para Pendiri Desa Warurejo</h3>
                                    </div>
                                </div>
                                
                                <div class="relative pl-8 sm:pl-12 md:pl-16">
                                    <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-red-200"></div>
                                    
                                    <div class="space-y-3 text-sm sm:text-base text-gray-700">
                                        <p class="font-semibold text-gray-800 mb-4">Tokoh-tokoh yang berjasa dalam pembentukan dan kepemimpinan Desa Warurejo:</p>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">1</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">DIPO GATI</h4>
                                                        <p class="text-xs text-red-700">Tahun 1830</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">2</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">DIPO SEMITO</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">3</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">DIPO YONO</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">4</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">DIPO SONO</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">5</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">TOHJOYO</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">6</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">WONOTIKO</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-400 hover:shadow-md transition md:col-span-2">
                                                <div class="flex items-center">
                                                    <span class="bg-red-200 text-red-800 font-bold px-3 py-1 rounded-full text-xs mr-3">7</span>
                                                    <div>
                                                        <h4 class="font-bold text-red-900">WONGSO WIJOYO / WONGSO SAIKUN</h4>
                                                        <p class="text-xs text-red-700">Periode 1959 - 1985</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-linear-to-r from-red-50 to-amber-50 rounded-lg p-4 mt-4 border border-red-200">
                                            <p class="text-sm italic text-gray-700">
                                                <svg class="w-5 h-5 inline-block mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                Para tokoh ini adalah perintis yang membuka dan mengembangkan Desa Warurejo menjadi permukiman yang makmur seperti sekarang.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
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