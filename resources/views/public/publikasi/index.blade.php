@extends('public.layouts.app')

@section('title', 'Publikasi - ' . $kategori)

@section('content')
<!-- Header Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-800 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-4">Publikasi Desa</h1>
        <p class="text-xl text-primary-100">Dokumen {{ $kategori }} Desa Warurejo</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Filter Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Kategori Dropdown -->
                        <div class="flex-1">
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kategori</label>
                            <select id="kategori" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-transparent"
                                    onchange="window.location.href = '{{ route('publikasi.index') }}?kategori=' + this.value + '{{ request('tahun') ? '&tahun=' . request('tahun') : '' }}'">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $kategori === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun Filter -->
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('publikasi.index', ['kategori' => $kategori]) }}" 
                               class="px-4 py-2 rounded-lg font-semibold transition {{ !request('tahun') ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            @foreach($availableYears as $year)
                                <a href="{{ route('publikasi.index', ['kategori' => $kategori, 'tahun' => $year]) }}" 
                                   class="px-4 py-2 rounded-lg font-semibold transition {{ request('tahun') == $year ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ $year }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Documents Grid -->
                <div class="space-y-4">
                    @forelse($publikasi as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="md:flex">
                                <!-- Thumbnail -->
                                <div class="md:w-48 md:flex-shrink-0">
                                    @if($item->thumbnail)
                                        <img src="{{ $item->thumbnail_url }}" 
                                             alt="{{ $item->judul }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                            <i class="fas fa-file-pdf text-6xl text-primary-600"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-6 flex-1">
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 bg-primary-100 text-primary-800 text-sm font-semibold rounded-full">
                                            {{ $item->kategori }}
                                        </span>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-semibold rounded-full">
                                            Tahun {{ $item->tahun }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-primary-600 transition">
                                        <a href="{{ route('publikasi.show', $item->id) }}">{{ $item->judul }}</a>
                                    </h3>

                                    @if($item->deskripsi)
                                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') }}
                                            <span class="mx-2">•</span>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            {{ $item->jumlah_download }} unduhan
                                        </div>

                                        <div class="flex gap-2">
                                            <a href="{{ route('publikasi.show', $item->id) }}" 
                                               class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-semibold transition duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat Detail
                                            </a>
                                            <a href="{{ route('publikasi.download', $item->id) }}" 
                                               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition duration-200">
                                                <i class="fas fa-download mr-1"></i>
                                                Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-md p-12 text-center">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Publikasi</h3>
                            <p class="text-gray-500">Belum ada dokumen {{ $kategori }} yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($publikasi->hasPages())
                    <div class="mt-8">
                        {{ $publikasi->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Publikasi Lainnya -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-primary-600"></i>
                        Publikasi Lainnya
                    </h3>
                    <div class="space-y-4">
                        @forelse($sidebarPublikasi as $item)
                            <a href="{{ route('publikasi.show', $item->id) }}" 
                               class="block group">
                                <div class="flex gap-3">
                                    <div class="w-16 h-16 flex-shrink-0 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-2xl text-primary-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ $item->kategori }}</span>
                                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-primary-600 transition mt-1 line-clamp-2">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @if(!$loop->last)
                                <hr class="border-gray-200">
                            @endif
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Tidak ada publikasi lainnya</p>
                        @endforelse
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-lg shadow-md p-6 mt-6 text-white">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-info-circle text-3xl mr-3"></i>
                        <h3 class="text-lg font-bold">Informasi</h3>
                    </div>
                    <p class="text-sm text-primary-100">
                        Dokumen publikasi desa tersedia untuk diunduh dalam format PDF. 
                        Pastikan Anda memiliki aplikasi pembaca PDF untuk membuka dokumen.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
