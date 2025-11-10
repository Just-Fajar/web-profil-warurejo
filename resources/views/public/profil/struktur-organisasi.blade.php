@extends('public.layouts.app')

@section('title', 'Struktur Organisasi - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Struktur Organisasi</h1>
            <p class="text-lg text-primary-100">
                Susunan Organisasi Pemerintahan Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Struktur Organisasi Content --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            {{-- Info Box --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-12">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-500 mr-3 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-2">Informasi</h3>
                        <p class="text-blue-800 leading-relaxed">
                            Struktur organisasi pemerintahan Desa Warurejo disusun berdasarkan Peraturan Menteri Dalam Negeri tentang Pedoman Nomenklatur Perangkat Desa dan dikelola secara profesional untuk memberikan pelayanan terbaik kepada masyarakat.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kepala Desa --}}
            <div class="mb-12">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="bg-linear-to-r from-blue-600 to-blue-700 p-6 text-center">
                        <h2 class="text-2xl font-bold text-white mb-2">KEPALA DESA</h2>
                        <p class="text-blue-100">Pemimpin Pemerintahan Desa</p>
                    </div>
                    <div class="p-8 text-center">
                        <div class="inline-block">
                            <div class="w-32 h-32 mx-auto mb-4 bg-linear-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-1">Nama Kepala Desa</h3>
                            <p class="text-gray-600 mb-3">Kepala Desa Warurejo</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sekretaris Desa & Perangkat --}}
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Perangkat Desa</h2>
                
                {{-- Sekretaris Desa --}}
                <div class="mb-8">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="bg-linear-to-r from-green-600 to-green-700 p-4 text-center">
                            <h3 class="text-xl font-bold text-white">SEKRETARIS DESA</h3>
                        </div>
                        <div class="p-6 text-center">
                            <div class="w-24 h-24 mx-auto mb-3 bg-linear-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center">
                                <svg class="w-14 h-14 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800">Nama Sekretaris Desa</h4>
                            <p class="text-gray-600">Sekretaris Desa</p>
                        </div>
                    </div>
                </div>

                {{-- Kaur (Kepala Urusan) --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Kepala Urusan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Kaur Tata Usaha & Umum --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kaur TU</h4>
                                <p class="text-gray-600 text-sm mb-2">Kaur Tata Usaha & Umum</p>
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">Administrasi</span>
                            </div>
                        </div>

                        {{-- Kaur Keuangan --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-yellow-100 to-yellow-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kaur Keuangan</h4>
                                <p class="text-gray-600 text-sm mb-2">Kaur Keuangan</p>
                                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Keuangan</span>
                            </div>
                        </div>

                        {{-- Kaur Perencanaan --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kaur Perencanaan</h4>
                                <p class="text-gray-600 text-sm mb-2">Kaur Perencanaan</p>
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Perencanaan</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kepala Dusun / Kasi --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Kepala Seksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Kasi Pemerintahan --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-indigo-100 to-indigo-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kasi Pemerintahan</h4>
                                <p class="text-gray-600 text-sm mb-2">Kasi Pemerintahan</p>
                                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">Pemerintahan</span>
                            </div>
                        </div>

                        {{-- Kasi Kesejahteraan --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-pink-100 to-pink-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kasi Kesejahteraan</h4>
                                <p class="text-gray-600 text-sm mb-2">Kasi Kesejahteraan</p>
                                <span class="inline-block px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-semibold">Kesejahteraan</span>
                            </div>
                        </div>

                        {{-- Kasi Pelayanan --}}
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto mb-3 bg-linear-to-br from-teal-100 to-teal-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Nama Kasi Pelayanan</h4>
                                <p class="text-gray-600 text-sm mb-2">Kasi Pelayanan</p>
                                <span class="inline-block px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-xs font-semibold">Pelayanan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg mb-12">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-amber-500 mr-3 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-2">Catatan</h3>
                        <p class="text-amber-800 leading-relaxed">
                            Struktur organisasi ini dapat berubah sesuai dengan kebutuhan dan perkembangan pemerintahan desa. 
                            Untuk informasi terkini, silakan hubungi kantor desa atau kunjungi papan informasi di kantor desa.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation Links --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('profil.visi-misi') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-green-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-3 mr-4 group-hover:bg-green-200 transition">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition">Visi & Misi</h3>
                            <p class="text-gray-600 text-sm">Lihat visi misi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profil.sejarah') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-amber-600">
                    <div class="flex items-center">
                        <div class="bg-amber-100 rounded-full p-3 mr-4 group-hover:bg-amber-200 transition">
                            <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-amber-600 transition">Sejarah</h3>
                            <p class="text-gray-600 text-sm">Sejarah desa</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
