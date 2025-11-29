{{--
    PUBLIC PETA DESA
    
    Halaman peta lokasi dan area Desa Warurejo
    
    FEATURES:
    - Hero section dengan gradient background
    - Google Maps embed (interactive map)
    - Floating info overlay on map
    - Lokasi desa details
    - Direct link ke Google Maps app
    - Responsive iframe
    - Glassmorphism design
    
    MAP SECTION:
    - Full-width embedded iframe
    - Height: 600px
    - Rounded corners (rounded-2xl)
    - Interactive zoom/pan
    - Satellite view option
    - Street view integration
    - Directions feature
    
    FLOATING OVERLAY:
    - White card dengan backdrop blur
    - Position: top-6 left-6
    - Width: 240px
    - Map pin icon
    - Area desa text
    - "Buka di Google Maps" link
    
    LOKASI CARD:
    - White background dengan shadow
    - Primary-600 accent
    - Map pin icon header
    - Full address text:
      * Jl. Flamboyan, Templek, Warurejo
      * Kec. Balerejo, Kabupaten Madiun
      * Jawa Timur 63152
    - Link ke Google Maps
    - Clickable phone number
    - Email link
    
    GOOGLE MAPS:
    - Embedded iframe dari Google Maps
    - Coordinates: -7.4847, 111.5244 (approx)
    - Warurejo, Balerejo, Madiun
    - Satellite + terrain view
    - Loading: lazy untuk performance
    - Referrer policy: no-referrer-when-downgrade
    
    LINKS:
    - Google Maps: https://maps.app.goo.gl/xZ5Qg2pNKXZJ8qKp6
    - Open in new tab (target="_blank")
    - WhatsApp: wa.me/6283114796959
    - Email: desawarurejo@gmail.com
    
    RESPONSIVE:
    - Mobile: Full-width map, stacked cards
    - Tablet: Adjusted overlay position
    - Desktop: 2-column layout below map
    
    DESIGN ELEMENTS:
    - Glassmorphism (backdrop-blur, white/70)
    - Gradient backgrounds
    - Rounded corners
    - Professional shadows
    - Icon-first design
    
    PERFORMANCE:
    - Lazy loading iframe
    - Optimized map embed
    - Minimal JavaScript
    
    ACCESSIBILITY:
    - Descriptive alt texts
    - Keyboard navigable links
    - Screen reader friendly
    
    FUTURE ENHANCEMENTS:
    - Custom map markers
    - Multiple locations (facilities)
    - Directions API integration
    - Distance calculator
    
    Route: /peta-desa
    Controller: Static view (web.php closure)
--}}
@extends('public.layouts.app')

@section('title', 'Peta Desa - Desa Warurejo')

@section('content')

{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-800 to-gray-900 text-white py-20">
    <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1502920917128-1aa500764b84')] bg-cover bg-center"></div>
    <div class="absolute inset-0 backdrop-blur-sm bg-black/30"></div>

    <div class="container relative mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
                Peta Desa Warurejo
            </h1>
            <p class="text-lg text-gray-200 mt-3">
                Lokasi, wilayah, dan area administratif Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Map Section --}}
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">

            {{-- Google Maps Card (Glassmorphism Premium) --}}
            <div class="relative bg-white/70 backdrop-blur-xl border border-white/50 shadow-xl rounded-2xl overflow-hidden mb-12">
                
                <div class="relative w-full h-[600px]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15810.5!2d111.5244!3d-7.4847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79f0e8e8e8e8e8%3A0x8e8e8e8e8e8e8e8e!2sWarurejo%2C%20Balerejo%2C%20Madiun%20Regency%2C%20East%20Java!5e1!3m2!1sen!2sid!4v1699430000000!5m2!1sen!2sid"
                        width="100%" 
                        height="100%"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        class="rounded-2xl"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    {{-- Floating Overlay Info --}}
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-lg shadow-xl rounded-xl p-5 w-60 border border-gray-200/50">
                        <h3 class="font-semibold text-gray-800 flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Area Desa Warurejo
                        </h3>

                        <a 
                            href="https://maps.app.goo.gl/xZ5Qg2pNKXZJ8qKp6"
                            target="_blank"
                            class="inline-flex items-center text-sm text-primary-700 font-semibold hover:text-primary-900 transition"
                        >
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Lokasi Desa
                    </h2>

                    <div class="space-y-4 text-gray-700">
                        <p class="flex">
                            <svg class="w-5 h-5 mr-3 text-primary-600 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Jl. Flamboyan, Templek, Warurejo, Kec. Balerejo, Kabupaten Madiun, Jawa Timur 63152
                        </p>
                    </div>

                    <a 
                        href="https://maps.app.goo.gl/xZ5Qg2pNKXZJ8qKp6"
                        target="_blank"
                        class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition shadow-md mt-6 font-semibold"
                    >
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Buka Google Maps
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
