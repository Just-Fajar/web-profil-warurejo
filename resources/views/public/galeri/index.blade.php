@extends('public.layouts.app')

@section('title', 'Galeri Dokumentasi - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-purple-600 to-purple-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri Dokumentasi</h1>
            <p class="text-lg text-purple-100">
                Kumpulan Foto dan Video Kegiatan Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Filter Section --}}
<section class="py-8 bg-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <form method="GET" action="{{ route('galeri.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari foto atau video..." 
                        value="{{ request('search') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                </div>
                <select 
                    name="tipe" 
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Tipe</option>
                    <option value="foto" {{ request('tipe') == 'foto' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
                <select 
                    name="kategori" 
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Kategori</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan Desa</option>
                    <option value="infrastruktur" {{ request('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="budaya" {{ request('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                    <option value="umkm" {{ request('kategori') == 'umkm' ? 'selected' : '' }}>UMKM</option>
                    <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold"
                >
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Gallery Grid --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            @if(isset($galeris) && $galeris->count() > 0)
                {{-- Masonry Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ openModal: false, modalSrc: '', modalTitle: '', modalDesc: '', modalType: 'foto' }">
                    @foreach($galeris as $galeri)
                        <div class="group relative bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition cursor-pointer"
                             @click="openModal = true; modalSrc = '{{ $galeri->file_url }}'; modalTitle = '{{ addslashes($galeri->judul) }}'; modalDesc = '{{ addslashes($galeri->deskripsi ?? '') }}'; modalType = '{{ $galeri->tipe }}'">
                            
                            {{-- Thumbnail --}}
                            <div class="relative overflow-hidden" style="height: {{ rand(200, 350) }}px;">
                                @if($galeri->tipe === 'foto')
                                    {{-- Photo --}}
                                    @if($galeri->file_url)
                                        <img 
                                            src="{{ $galeri->file_url }}" 
                                            alt="{{ $galeri->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        >
                                    @else
                                        <div class="w-full h-full bg-linear-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                @else
                                    {{-- Video Thumbnail --}}
                                    @if($galeri->thumbnail_url)
                                        <img 
                                            src="{{ $galeri->thumbnail_url }}" 
                                            alt="{{ $galeri->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        >
                                    @else
                                        <div class="w-full h-full bg-linear-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Play Button Overlay --}}
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                            <svg class="w-8 h-8 text-purple-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white font-bold text-lg mb-1">{{ $galeri->judul }}</h3>
                                        @if($galeri->tanggal)
                                            <p class="text-white/80 text-sm">{{ \Carbon\Carbon::parse($galeri->tanggal)->format('d F Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                {{-- Type Badge --}}
                                <div class="absolute top-3 left-3">
                                    @if($galeri->tipe === 'foto')
                                        <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                            FOTO
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                            </svg>
                                            VIDEO
                                        </span>
                                    @endif
                                </div>
                                
                                {{-- Category Badge --}}
                                @if($galeri->kategori)
                                    <div class="absolute top-3 right-3">
                                        @php
                                            $kategoriColors = [
                                                'kegiatan' => 'bg-green-600',
                                                'infrastruktur' => 'bg-amber-600',
                                                'budaya' => 'bg-purple-600',
                                                'umkm' => 'bg-blue-600',
                                                'lainnya' => 'bg-gray-600',
                                            ];
                                            $bgColor = $kategoriColors[$galeri->kategori] ?? 'bg-gray-600';
                                        @endphp
                                        <span class="px-3 py-1 {{ $bgColor }} text-white text-xs font-semibold rounded-full uppercase">
                                            {{ $galeri->kategori }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Info --}}
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $galeri->judul }}</h3>
                                @if($galeri->deskripsi)
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $galeri->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- Modal --}}
                    <div x-show="openModal" 
                         x-cloak
                         @click.self="openModal = false"
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        
                        <div class="relative max-w-5xl w-full bg-white rounded-lg shadow-2xl overflow-hidden"
                             @click.stop>
                            
                            {{-- Close Button --}}
                            <button @click="openModal = false" 
                                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            
                            {{-- Media Content --}}
                            <div class="bg-black flex items-center justify-center" style="max-height: 70vh;">
                                <template x-if="modalType === 'foto'">
                                    <img :src="modalSrc" :alt="modalTitle" class="max-w-full max-h-full object-contain">
                                </template>
                                <template x-if="modalType === 'video'">
                                    <video :src="modalSrc" controls class="max-w-full max-h-full">
                                        Your browser does not support the video tag.
                                    </video>
                                </template>
                            </div>
                            
                            {{-- Info --}}
                            <div class="p-6">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2" x-text="modalTitle"></h2>
                                <p class="text-gray-600" x-text="modalDesc"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $galeris->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Dokumentasi</h3>
                    <p class="text-gray-600 mb-6">
                        @if(request('search') || request('tipe') || request('kategori'))
                            Tidak ditemukan dokumentasi dengan kriteria yang Anda cari.
                        @else
                            Saat ini belum ada dokumentasi foto atau video yang tersedia. Silakan kembali lagi nanti.
                        @endif
                    </p>
                    @if(request('search') || request('tipe') || request('kategori'))
                        <a href="{{ route('galeri.index') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                            Lihat Semua Dokumentasi
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</section>

{{-- Statistics Section --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Kategori Dokumentasi</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                
                <div class="text-center p-6 bg-linear-to-br from-green-50 to-green-100 rounded-lg border-2 border-green-200 hover:border-green-400 transition">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Kegiatan</h3>
                </div>

                <div class="text-center p-6 bg-linear-to-br from-amber-50 to-amber-100 rounded-lg border-2 border-amber-200 hover:border-amber-400 transition">
                    <div class="w-16 h-16 bg-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Infrastruktur</h3>
                </div>

                <div class="text-center p-6 bg-linear-to-br from-purple-50 to-purple-100 rounded-lg border-2 border-purple-200 hover:border-purple-400 transition">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Budaya</h3>
                </div>

                <div class="text-center p-6 bg-linear-to-br from-blue-50 to-blue-100 rounded-lg border-2 border-blue-200 hover:border-blue-400 transition">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">UMKM</h3>
                </div>

                <div class="text-center p-6 bg-linear-to-br from-gray-50 to-gray-100 rounded-lg border-2 border-gray-200 hover:border-gray-400 transition">
                    <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Lainnya</h3>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
