@extends('public.layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero + Navbar dalam satu section -->
<section 
    class="relative flex flex-col justify-center items-center bg-cover bg-center bg-no-repeat min-h-screen text-white" 
    style="background-image: url('{{ asset('images/pemandangan-alam.jpg') }}');"
>

    
    <!-- Overlay agar teks dan navbar kontras -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Navbar dimasukkan di sini -->
<div class="absolute top-0 left-0 w-full z-20">
    @include('public.partials.navbar')
</div>


    <!-- Hero Text -->
    <div class="relative z-10 container mx-auto px-4 py-24 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Selamat Datang di Website Resmi {{ $profil->nama_desa }}
        </h1>
        <p class="text-lg md:text-xl text-primary-100 mb-8">
            {{ $profil->kecamatan }}, {{ $profil->kabupaten }}, {{ $profil->provinsi }}
        </p>
    </div>
</section>


<!-- Stats Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ number_format($profil->jumlah_penduduk) }}</div>
                <div class="text-gray-600">Jiwa Penduduk</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ number_format($profil->luas_wilayah, 2) }}</div>
                <div class="text-gray-600">Ha Luas Wilayah</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $potensi->count() }}</div>
                <div class="text-gray-600">Potensi Desa</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $latest_berita->count() }}</div>
                <div class="text-gray-600">Berita Terbaru</div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Berita Terkini</h2>
            <p class="text-gray-600">Informasi dan kabar terbaru dari Desa {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($latest_berita as $berita)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">
                            {{ $berita->published_at?->format('d M Y') }}
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $berita->excerpt }}
                        </p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="text-primary-600 font-semibold hover:text-primary-800">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Belum ada berita tersedia</p>
                </div>
            @endforelse
        </div>

        @if($latest_berita->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('berita.index') }}" class="inline-block bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition">
                    Lihat Semua Berita
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Potensi Desa -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Potensi Desa</h2>
            <p class="text-gray-600">Kekayaan dan potensi yang dimiliki Desa {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($potensi->take(4) as $item)
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $item->nama_potensi }}</h3>
                    <p class="text-sm text-gray-600">{{ $item->kategori_label }}</p>
                </div>
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">Belum ada data potensi</p>
                </div>
            @endforelse
        </div>

        @if($potensi->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('potensi.index') }}" class="inline-block border-2 border-primary-600 text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:text-white transition">
                    Lihat Semua Potensi
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Gallery Preview -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Dokumentasi Kegiatan</h2>
            <p class="text-gray-600">Dokumentasi kegiatan dan momen penting di Desa {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($galeri as $item)
                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition group">
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute inset-0 bg-linear-to-t from-black/70 to-transparent flex items-end p-4">
                        <h3 class="text-white font-semibold">{{ $item->judul }}</h3>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Belum ada dokumentasi</p>
                </div>
            @endforelse
        </div>

        @if($galeri->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('galeri.index') }}" class="inline-block bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition">
                    Lihat Semua Galeri
                </a>
            </div>
        @endif
    </div>
</section>
@endsection