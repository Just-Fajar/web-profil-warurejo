@extends('public.layouts.app')

@section('title', 'Berita Desa - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita Desa</h1>
            <p class="text-lg text-primary-100">
                Informasi dan Kabar Terbaru dari Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Berita Content --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Search & Filter --}}
            <div class="mb-8 bg-white rounded-lg shadow-md p-6">
                <form method="GET" action="{{ route('berita.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari berita..." 
                            value="{{ request('search') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </form>
            </div>

            {{-- Berita List --}}
            @if(isset($beritas) && $beritas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($beritas as $berita)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            {{-- Gambar --}}
                            <div class="relative overflow-hidden h-48">
                                @if($berita->gambar_url)
                                    <img 
                                        src="{{ $berita->gambar_url }}" 
                                        alt="{{ $berita->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                    >
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-primary-600 text-white text-xs font-semibold rounded-full">
                                        Berita
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                {{-- Meta Info --}}
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $berita->tanggal_publikasi->format('d M Y') }}</span>
                                    
                                    @if($berita->penulis)
                                        <span class="mx-2">•</span>
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $berita->penulis }}</span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-primary-600 transition line-clamp-2">
                                    {{ $berita->judul }}
                                </h3>

                                {{-- Excerpt --}}
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $berita->excerpt ?? Str::limit(strip_tags($berita->konten), 120) }}
                                </p>

                                {{-- Read More --}}
                                <a 
                                    href="{{ route('berita.show', $berita->slug) }}" 
                                    class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold"
                                >
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $beritas->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Berita</h3>
                    <p class="text-gray-600 mb-6">
                        @if(request('search'))
                            Tidak ditemukan berita dengan kata kunci "{{ request('search') }}".
                        @else
                            Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('berita.index') }}" class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold">
                            Lihat Semua Berita
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-16 bg-linear-to-r from-primary-600 to-primary-700">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Punya Informasi atau Berita?
            </h2>
            <p class="text-lg text-primary-100 mb-8">
                Bagikan informasi atau kegiatan di desa Anda kepada kami
            </p>
            <a 
                href="https://wa.me/6283114796959?text=Halo,%20saya%20ingin%20berbagi%20informasi%20berita%20desa" 
                target="_blank"
                class="inline-flex items-center px-8 py-4 bg-white text-primary-600 rounded-lg hover:bg-primary-50 transition font-bold text-lg shadow-lg"
            >
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
