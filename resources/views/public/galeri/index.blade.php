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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ openModal: false, modalSrc: '', modalTitle: '', modalDesc: '', modalImages: [] }">
                    @foreach($galeris as $galeri)
                        <div class="group relative bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition cursor-pointer"
                             @click="openModal = true; modalImages = @js($galeri->images->map(fn($img) => ['url' => asset('storage/' . $img->image_path)])->toArray()); modalTitle = '{{ addslashes($galeri->judul) }}'; modalDesc = '{{ addslashes($galeri->deskripsi ?? '') }}'">
                            
                            {{-- Thumbnail - Show first image from images relation --}}
                            <div class="relative overflow-hidden h-64">
                                @if($galeri->images && $galeri->images->count() > 0)
                                    <img 
                                        src="{{ $galeri->images->first()->image_url }}" 
                                        alt="{{ $galeri->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                    >
                                    
                                    {{-- Multiple Images Badge --}}
                                    @if($galeri->images->count() > 1)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1 bg-black/70 text-white text-xs font-semibold rounded-full">
                                                <i class="fas fa-images mr-1"></i>{{ $galeri->images->count() }} Foto
                                            </span>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
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
                    
                    {{-- Modal with Image Carousel --}}
                    <div x-show="openModal" 
                         x-cloak
                         @click.self="openModal = false"
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-data="{ currentIndex: 0 }">
                        
                        <div class="relative max-w-5xl w-full bg-white rounded-lg shadow-2xl overflow-hidden"
                             @click.stop>
                            
                            {{-- Close Button --}}
                            <button @click="openModal = false" 
                                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            
                            {{-- Image Carousel --}}
                            <div class="bg-black flex items-center justify-center relative" style="max-height: 70vh;">
                                <template x-for="(image, index) in modalImages" :key="index">
                                    <img x-show="currentIndex === index" 
                                         :src="image.url" 
                                         :alt="modalTitle" 
                                         class="max-w-full max-h-full object-contain"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100">
                                </template>
                                
                                {{-- Navigation Arrows (only show if multiple images) --}}
                                <template x-if="modalImages.length > 1">
                                    <div>
                                        <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : modalImages.length - 1" 
                                                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition">
                                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <button @click="currentIndex = currentIndex < modalImages.length - 1 ? currentIndex + 1 : 0" 
                                                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition">
                                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            {{-- Info --}}
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-2xl font-bold text-gray-800" x-text="modalTitle"></h2>
                                    <span x-show="modalImages.length > 1" class="text-sm text-gray-600" x-text="(currentIndex + 1) + ' / ' + modalImages.length"></span>
                                </div>
                                <p class="text-gray-600" x-text="modalDesc || 'Tidak ada deskripsi'"></p>
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
@endsection
