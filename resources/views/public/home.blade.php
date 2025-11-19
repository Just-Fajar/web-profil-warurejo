@extends('public.layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero + Navbar dalam satu section -->
<section 
    class="relative flex flex-col justify-center items-center bg-cover bg-center bg-no-repeat min-h-screen text-white" 
    style="background-image: url('{{ asset('images/logo-web-desa.jpg') }}');"
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
        <h1 class="text-lg md:text-xl text-white">
            Kecamatan Balerejo, Kabupaten Madiun
        </h1>
    </div>
</section>


<!-- Stats Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $potensi->count() }}</div>
                <div class="text-gray-600">Potensi Desa</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $latest_berita->count() }}</div>
                <div class="text-gray-600">Berita Terbaru</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $galeri->count() }}</div>
                <div class="text-gray-600">Dokumentasi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ number_format($totalVisitors) }}</div>
                <div class="text-gray-600">Pengunjung</div>
            </div>
        </div>
    </div>
</section>

                <!-- Sambutan Kepala Desa -->
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-2">Selamat Datang</h2>
                        </div>

                        <div class="max-w-7xl mx-auto">
                            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 items-start">
                                
                                <!-- Photo (Mobile: Top, Desktop: Right) -->
                                <div class="lg:col-span-2 order-1 lg:order-2">
                                    <div class="relative h-full max-w-sm mx-auto lg:max-w-none">
                                        <!-- Yellow Corner Decorations -->
                                        <div class="absolute top-0 right-0 w-12 h-12 border-t-4 border-r-4 border-amber-400 rounded-tr-2xl"></div>
                                        <div class="absolute bottom-0 left-0 w-12 h-12 border-b-4 border-l-4 border-amber-400 rounded-bl-2xl"></div>
                                        
                                        <!-- Photo Container -->
                                        <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-2xl h-full min-h-[350px] lg:min-h-[450px] mt-6 mb-6 lg:mt-0 lg:mb-0">
                                            <img 
                    src="{{ asset('images/pemandangan-alam.jpg') }}" 
                    alt="Kepala Desa {{ $profil->nama_desa }}"
                    class="max-w-xs md:max-w-sm lg:max-w-md h-auto mx-auto object-contain"
                >

                                        </div>
                                    </div>
                                </div>

                <!-- Text Content (Mobile: Bottom, Desktop: Left) -->
                <div class="lg:col-span-3 order-2 lg:order-1">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-primary-700 mb-4 text-center lg:text-left">
                        SAMBUTAN KEPALA {{ strtoupper($profil->nama_desa) }}
                    </h3>
                    <div class="w-20 h-1 bg-amber-400 mb-6 mx-auto lg:mx-0"></div>
                    
                    <div class="text-gray-700 space-y-4 text-justify leading-relaxed text-sm md:text-base">
                        <p class="font-medium">Assalamu'alaikum warahmatullahi wabarakatuh,</p>
                        <p>Salam sejahtera bagi kita semua,</p>
                        <p>
                            Dengan penuh rasa syukur, saya menyambut seluruh warga dan pengunjung di website resmi Desa {{ $profil->nama_desa }}. 
                            Website ini kami hadirkan sebagai wujud keterbukaan informasi dan upaya dalam memajukan desa menuju kemandirian berbasis teknologi.
                        </p>
                        <p>
                            Sebagai Kepala Desa, saya bersama seluruh perangkat desa berkomitmen untuk membangun Desa {{ $profil->nama_desa }} yang mandiri, maju, dan berdaya saing dengan memanfaatkan teknologi sebagai pilar utama pembangunan.
                        </p>
                        <p>
                            Melalui platform ini, kami berharap dapat memberikan kemudahan akses informasi, pelayanan yang lebih baik, serta menjadi jembatan komunikasi antara pemerintah desa dan masyarakat. 
                            Mari bersama-sama membangun desa yang lebih maju, sejahtera, dan berdaya saing di era digital ini.
                        </p>
                        <p class="font-medium">Wassalamu'alaikum warahmatullahi wabarakatuh.</p>
                        
                        <div class="mt-8">
                            <p class="text-lg md:text-xl font-bold text-gray-800">{{ strtoupper($profil->nama_kepala_desa ?? 'Sunarto') }}</p>
                            <p class="text-gray-600">Kepala {{ $profil->nama_desa }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Potensi Desa</h2>
            <p class="text-gray-600">Kekayaan dan potensi yang dimiliki {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($potensi->take(4) as $item)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">

                    {{-- Gambar --}}
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         alt="{{ $item->nama_potensi }}"
                         class="w-full h-40 object-cover">

                    {{-- Konten Card --}}
                    <div class="p-5 text-left">

                        {{-- Kategori --}}
                        <span class="text-sm text-primary-600 font-semibold tracking-wide">
                            {{ $item->kategori_label }}
                        </span>

                        {{-- Nama --}}
                        <h3 class="mt-2 font-bold text-gray-800 text-lg">
                            {{ $item->nama_potensi }}
                        </h3>

                        {{-- Lokasi --}}
                        <p class="text-gray-600 text-sm mt-1">
                            📍 <strong>Lokasi:</strong> {{ $item->lokasi }}
                        </p>

                        {{-- WhatsApp --}}
                        @if ($item->whatsapp)
                        <p class="text-gray-600 text-sm mt-1">
                            📞 <strong>WhatsApp:</strong> +62{{ $item->whatsapp }}
                        </p>
                        @endif

                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">Belum ada data potensi</p>
                </div>
            @endforelse
        </div>

        @if($potensi->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('potensi.index') }}" 
                   class="inline-block border-2 border-primary-600 text-primary-600 
                          px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 
                          hover:text-white transition">
                    Lihat Semua Potensi
                </a>
            </div>
        @endif

    </div>
</section>

<!-- Latest News -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Berita Terkini</h2>
            <p class="text-gray-600">Informasi dan kabar terbaru dari {{ $profil->nama_desa }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($latest_berita as $berita)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="{{ $berita->gambar_utama_url }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
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

<!-- Gallery Preview -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Galeri</h2>
            <p class="text-gray-600">Dokumentasi kegiatan dan momen penting di {{ $profil->nama_desa }}</p>
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