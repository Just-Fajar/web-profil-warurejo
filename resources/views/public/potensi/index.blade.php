@extends('public.layouts.app')

@section('title', 'Potensi Desa - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-green-600 to-green-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Potensi Desa</h1>
            <p class="text-lg text-green-100">
                Kekayaan dan Potensi yang Dimiliki Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Potensi Content --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Filter & Search --}}
            <div class="mb-8 bg-white rounded-lg shadow-md p-6">
                <form method="GET" action="{{ route('potensi.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari potensi desa..." 
                            value="{{ request('search') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        >
                    </div>
                    <select 
                        name="kategori" 
                        class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    >
                        <option value="">Semua Kategori</option>
                        <option value="pertanian" {{ request('kategori') == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="peternakan" {{ request('kategori') == 'peternakan' ? 'selected' : '' }}>Peternakan</option>
                        <option value="umkm" {{ request('kategori') == 'umkm' ? 'selected' : '' }}>UMKM</option>
                        <option value="wisata" {{ request('kategori') == 'wisata' ? 'selected' : '' }}>Wisata</option>
                        <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </form>
            </div>

            {{-- Potensi List --}}
            @if(isset($potensis) && $potensis->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($potensis as $potensi)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            {{-- Gambar --}}
                            <div class="relative overflow-hidden h-56">
                                @if($potensi->gambar_url)
                                    <img 
                                        src="{{ $potensi->gambar_url }}" 
                                        alt="{{ $potensi->nama }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                    >
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-green-400 to-green-600 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-3 right-3">
                                    @php
                                        $kategoriColors = [
                                            'pertanian' => 'bg-green-600',
                                            'peternakan' => 'bg-amber-600',
                                            'umkm' => 'bg-blue-600',
                                            'wisata' => 'bg-purple-600',
                                            'lainnya' => 'bg-gray-600',
                                        ];
                                        $bgColor = $kategoriColors[$potensi->kategori ?? 'lainnya'] ?? 'bg-gray-600';
                                    @endphp
                                    <span class="px-3 py-1 {{ $bgColor }} text-white text-xs font-semibold rounded-full uppercase">
                                        {{ $potensi->kategori ?? 'Lainnya' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                {{-- Title --}}
                                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-green-600 transition line-clamp-2">
                                    {{ $potensi->nama }}
                                </h3>

                                {{-- Description --}}
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $potensi->deskripsi_singkat ?? Str::limit(strip_tags($potensi->deskripsi), 120) }}
                                </p>

                                {{-- Meta Info --}}
                                @if($potensi->lokasi)
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $potensi->lokasi }}</span>
                                    </div>
                                @endif

                                {{-- Read More --}}
                                <a 
                                    href="{{ route('potensi.show', $potensi->slug) }}" 
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold"
                                >
                                    Lihat Detail
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
                    {{ $potensis->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Potensi</h3>
                    <p class="text-gray-600 mb-6">
                        @if(request('search') || request('kategori'))
                            Tidak ditemukan potensi dengan kriteria yang Anda cari.
                        @else
                            Saat ini belum ada data potensi desa yang ditampilkan. Silakan kembali lagi nanti.
                        @endif
                    </p>
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('potensi.index') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                            Lihat Semua Potensi
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</section>

{{-- Info Section --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Kategori Potensi Desa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Pertanian --}}
                <div class="bg-linear-to-br from-green-50 to-green-100 rounded-lg p-6 border-2 border-green-200 hover:border-green-400 transition">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pertanian</h3>
                    <p class="text-gray-600 text-sm">Potensi hasil pertanian seperti padi, jagung, dan sayuran</p>
                </div>

                {{-- Peternakan --}}
                <div class="bg-linear-to-br from-amber-50 to-amber-100 rounded-lg p-6 border-2 border-amber-200 hover:border-amber-400 transition">
                    <div class="w-16 h-16 bg-amber-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Peternakan</h3>
                    <p class="text-gray-600 text-sm">Potensi peternakan sapi, kambing, ayam, dan lainnya</p>
                </div>

                {{-- UMKM --}}
                <div class="bg-linear-to-br from-blue-50 to-blue-100 rounded-lg p-6 border-2 border-blue-200 hover:border-blue-400 transition">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">UMKM</h3>
                    <p class="text-gray-600 text-sm">Usaha mikro, kecil, dan menengah produk lokal</p>
                </div>

                {{-- Wisata --}}
                <div class="bg-linear-to-br from-purple-50 to-purple-100 rounded-lg p-6 border-2 border-purple-200 hover:border-purple-400 transition">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Wisata</h3>
                    <p class="text-gray-600 text-sm">Potensi wisata alam, budaya, dan edukasi</p>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-16 bg-linear-to-r from-green-600 to-green-700">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Tertarik dengan Potensi Desa?
            </h2>
            <p class="text-lg text-green-100 mb-8">
                Hubungi kami untuk informasi lebih lanjut mengenai potensi dan kerjasama
            </p>
            <a 
                href="https://wa.me/6283114796959?text=Halo,%20saya%20ingin%20mengetahui%20lebih%20lanjut%20tentang%20potensi%20desa" 
                target="_blank"
                class="inline-flex items-center px-8 py-4 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-bold text-lg shadow-lg"
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
