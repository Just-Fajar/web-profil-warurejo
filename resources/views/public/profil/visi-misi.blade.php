@extends('public.layouts.app')

@section('title', 'Visi & Misi - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Visi & Misi</h1>
            <p class="text-lg text-primary-100">
                Visi dan Misi Desa Warurejo dalam Mewujudkan Desa yang Maju dan Sejahtera
            </p>
        </div>
    </div>
</section>

{{-- Visi & Misi Content --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            
            {{-- Visi Section --}}
            <div class="mb-16">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-linear-to-r from-primary-600 to-primary-700 p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-full p-4 mr-4">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">VISI</h2>
                                <p class="text-primary-100">Pandangan Masa Depan Desa Warurejo</p>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8">
                        @if($profil->visi)
                            <div class="relative">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary-600"></div>
                                <div class="pl-6">
                                    <p class="text-xl md:text-2xl text-gray-800 leading-relaxed font-medium italic">
                                        "{{ $profil->visi }}"
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-500">Visi belum tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Misi Section --}}
            <div class="mb-16">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-linear-to-r from-green-600 to-green-700 p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-full p-4 mr-4">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">MISI</h2>
                                <p class="text-green-100">Langkah Strategis Mewujudkan Visi</p>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8">
                        @if($profil->misi && count($profil->misi_array) > 0)
                            <div class="space-y-4">
                                @foreach($profil->misi_array as $index => $misi)
                                    <div class="flex items-start group hover:bg-green-50 p-4 rounded-lg transition">
                                        <div class="shrink-0 w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg mr-4 group-hover:scale-110 transition">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <p class="text-gray-800 text-lg leading-relaxed">{{ $misi }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-500">Misi belum tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-500 mr-3 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-2">Komitmen Kami</h3>
                        <p class="text-blue-800 leading-relaxed">
                            Visi dan misi ini menjadi pedoman bagi seluruh aparatur desa dan masyarakat dalam melaksanakan pembangunan desa. 
                            Dengan gotong royong dan kerja sama yang baik, kita yakin dapat mewujudkan Desa Warurejo yang lebih maju, mandiri, dan sejahtera.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation Links --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('profil.sejarah') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-green-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-3 mr-4 group-hover:bg-green-200 transition">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition">Sejarah Desa</h3>
                            <p class="text-gray-600 text-sm">Lihat sejarah desa</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profil.struktur-organisasi') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-green-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-3 mr-4 group-hover:bg-green-200 transition">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition">Struktur Organisasi</h3>
                            <p class="text-gray-600 text-sm">Lihat struktur organisasi desa</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
