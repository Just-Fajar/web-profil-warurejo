@extends('public.layouts.app')

@section('title', $berita->judul . ' - Desa Warurejo')

@section('content')
{{-- Breadcrumb --}}
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-primary-600">Beranda</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('berita.index') }}" class="hover:text-primary-600">Berita</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="text-gray-800 font-semibold truncate">{{ Str::limit($berita->judul, 50) }}</span>
        </div>
    </div>
</section>

{{-- Article Content --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            {{-- Article Header --}}
            <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                {{-- Featured Image --}}
                @if($berita->gambar_url)
                    <div class="relative h-96 overflow-hidden">
                        <img 
                            src="{{ $berita->gambar_url }}" 
                            alt="{{ $berita->judul }}"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-linear-to-t from-black/50 to-transparent"></div>
                    </div>
                @endif

                <div class="p-8">
                    {{-- Category & Date --}}
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        <span class="px-4 py-2 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full">
                            Berita Desa
                        </span>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $berita->tanggal_publikasi->format('d F Y') }}</span>
                        </div>
                        @if($berita->penulis)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $berita->penulis }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $berita->judul }}
                    </h1>

                    {{-- Content --}}
                    <div class="prose prose-lg max-w-none">
                        {!! $berita->konten !!}
                    </div>

                    {{-- Tags (if any) --}}
                    @if(isset($berita->tags) && $berita->tags)
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $berita->tags) as $tag)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Share Buttons --}}
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <p class="text-gray-700 font-semibold mb-4">Bagikan:</p>
                        <div class="flex flex-wrap gap-3">
                            <a 
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('berita.show', $berita->slug)) }}" 
                                target="_blank"
                                class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <a 
                                href="https://twitter.com/intent/tweet?url={{ urlencode(route('berita.show', $berita->slug)) }}&text={{ urlencode($berita->judul) }}" 
                                target="_blank"
                                class="flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </a>
                            <a 
                                href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . route('berita.show', $berita->slug)) }}" 
                                target="_blank"
                                class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Related News --}}
            @if(isset($relatedNews) && $relatedNews->count() > 0)
                <section class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedNews as $related)
                            <a href="{{ route('berita.show', $related->slug) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                @if($related->gambar_url)
                                    <div class="relative h-40 overflow-hidden">
                                        <img 
                                            src="{{ $related->gambar_url }}" 
                                            alt="{{ $related->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                        >
                                    </div>
                                @endif
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-2">{{ $related->tanggal_publikasi->format('d M Y') }}</p>
                                    <h3 class="font-bold text-gray-800 group-hover:text-primary-600 transition line-clamp-2">
                                        {{ $related->judul }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Back Button --}}
            <div class="mt-12 text-center">
                <a 
                    href="{{ route('berita.index') }}" 
                    class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar Berita
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
