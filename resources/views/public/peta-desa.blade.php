@extends('public.layouts.app')

@section('title', 'Peta Desa - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Peta Desa</h1>
            <p class="text-lg text-primary-100">
                Lokasi dan Wilayah Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Map Section --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Google Maps Embed --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="relative w-full" style="height: 600px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15810.5!2d111.5244!3d-7.4847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79f0e8e8e8e8e8%3A0x8e8e8e8e8e8e8e8e!2sWarurejo%2C%20Balerejo%2C%20Madiun%20Regency%2C%20East%20Java!5e1!3m2!1sen!2sid!4v1699430000000!5m2!1sen!2sid"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                    
                    {{-- Info Overlay --}}
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg p-4 z-10 max-w-xs">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-primary-600 mr-2 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 mb-2">Area Wilayah Desa Warurejo</p>
                                <a 
                                    href="https://maps.app.goo.gl/xZ5Qg2pNKXZJ8qKp6" 
                                    target="_blank"
                                    class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Buka Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Lokasi --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Lokasi Desa
                    </h2>
                    <div class="space-y-3 text-gray-700">
                        <p class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-primary-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Jl. Flamboyan, Templek, Warurejo, Kec. Balerejo, Kabupaten Madiun, Jawa Timur 63152</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span>083114796959</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>galaxydigitalindonesia@gmail.com</span>
                        </p>
                    </div>
                    <div class="mt-6">
                        <a 
                            href="https://maps.app.goo.gl/xZ5Qg2pNKXZJ8qKp6" 
                            target="_blank"
                            class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold shadow-md"
                        >
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"/>
                        </svg>
                        Batas Wilayah
                    </h2>
                    <div class="space-y-4 text-gray-700">
                        <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                            <div class="flex-shrink-0 w-20 font-semibold text-blue-900">Utara</div>
                            <div class="flex-1">Desa Templek</div>
                        </div>
                        <div class="flex items-start p-3 bg-green-50 rounded-lg">
                            <div class="flex-shrink-0 w-20 font-semibold text-green-900">Selatan</div>
                            <div class="flex-1">Desa Mojopurno</div>
                        </div>
                        <div class="flex items-start p-3 bg-amber-50 rounded-lg">
                            <div class="flex-shrink-0 w-20 font-semibold text-amber-900">Timur</div>
                            <div class="flex-1">Desa Sumberbendo</div>
                        </div>
                        <div class="flex items-start p-3 bg-purple-50 rounded-lg">
                            <div class="flex-shrink-0 w-20 font-semibold text-purple-900">Barat</div>
                            <div class="flex-1">Desa Balerejo</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Akses Transportasi --}}
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                    Akses Transportasi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 border border-gray-200 rounded-lg hover:border-primary-600 transition">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Kendaraan Pribadi</h3>
                        <p class="text-sm text-gray-600">Akses jalan raya yang baik</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg hover:border-primary-600 transition">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 7H7v6h6V7z"/>
                                <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Transportasi Umum</h3>
                        <p class="text-sm text-gray-600">Angkutan umum tersedia</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg hover:border-primary-600 transition">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Jarak Tempuh</h3>
                        <p class="text-sm text-gray-600">15 km dari pusat kota</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
