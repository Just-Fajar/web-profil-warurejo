@extends('public.layouts.app')

@section('title', 'Berita Desa - Desa Warurejo')

@section('content')
{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-600 to-primary-800 text-white py-8 sm:py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center scroll-reveal">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4">Berita Desa</h1>
            <p class="text-base sm:text-lg md:text-xl text-primary-100 px-4">
                Informasi dan Kabar Terbaru dari Desa Warurejo
            </p>
        </div>
    </div>
</section>

{{-- Berita Content --}}
<section class="py-8 sm:py-12 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            {{-- Search & Filter --}}
            <div class="mb-6 sm:mb-8 bg-white rounded-lg shadow-md p-4 sm:p-6 scroll-reveal">
                <form method="GET" action="{{ route('berita.index') }}" class="space-y-4" x-data="searchAutocomplete()">
                    
                    {{-- Search Input with Autocomplete --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Berita</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                x-model="searchQuery"
                                @input.debounce.300ms="fetchSuggestions()"
                                @focus="showSuggestions = true"
                                @click.away="showSuggestions = false"
                                placeholder="Cari berita berdasarkan judul atau konten..." 
                                value="{{ request('search') }}"
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pr-10 border border-gray-300 rounded-lg text-sm sm:text-base focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                            <svg class="w-5 h-5 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            
                            {{-- Autocomplete Dropdown --}}
                            <div 
                                x-show="showSuggestions && suggestions.length > 0"
                                x-transition
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-64 overflow-y-auto"
                            >
                                <template x-for="suggestion in suggestions" :key="suggestion.url">
                                    <a 
                                        :href="suggestion.url"
                                        class="block px-4 py-3 hover:bg-primary-50 border-b border-gray-100 last:border-b-0 transition"
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span x-text="suggestion.title" class="text-sm text-gray-800"></span>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Advanced Filters Row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        
                        {{-- Date From --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input 
                                type="date" 
                                name="date_from" 
                                value="{{ request('date_from') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg text-sm sm:text-base focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                        </div>
                        
                        {{-- Date To --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                            <input 
                                type="date" 
                                name="date_to" 
                                value="{{ request('date_to') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                        </div>
                        
                        {{-- Sort By --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select 
                                name="sort"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                                <option value="latest" {{ request('sort') === 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>
                        
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <button 
                            type="submit" 
                            class="flex-1 sm:flex-none px-4 sm:px-6 py-2.5 sm:py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold inline-flex items-center justify-center text-sm sm:text-base"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Terapkan Filter
                        </button>
                        
                        @if(request()->anyFilled(['search', 'date_from', 'date_to', 'sort']))
                        <a 
                            href="{{ route('berita.index') }}" 
                            class="flex-1 sm:flex-none px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold inline-flex items-center justify-center text-sm sm:text-base"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset Filter
                        </a>
                        @endif
                    </div>
                    
                    {{-- Active Filters Display --}}
                    @if(request()->anyFilled(['search', 'date_from', 'date_to', 'sort']))
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-200">
                        <span class="text-sm text-gray-600 font-medium">Filter aktif:</span>
                        
                        @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            "{{ request('search') }}"
                        </span>
                        @endif
                        
                        @if(request('date_from') || request('date_to'))
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d M Y') : 'Awal' }} 
                            - 
                            {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d M Y') : 'Akhir' }}
                        </span>
                        @endif
                        
                        @if(request('sort') && request('sort') !== 'latest')
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                            {{ request('sort') === 'oldest' ? 'Terlama' : 'Terpopuler' }}
                        </span>
                        @endif
                    </div>
                    @endif
                    
                </form>
            </div>

            {{-- Berita List --}}
            @if(isset($berita) && $berita->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                    @foreach($berita as $item)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group scroll-reveal-stagger">
                            {{-- Gambar --}}
                            <div class="relative overflow-hidden h-40 sm:h-44 md:h-48">
                                @if($item->gambar_utama)
                                    <img 
                                        src="{{ $item->gambar_utama_url }}" 
                                        alt="{{ $item->judul }}"
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
                            <div class="p-4 sm:p-6">
                                {{-- Meta Info --}}
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</span>
                                    
                                    @if($item->admin)
                                        <span class="mx-2">•</span>
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $item->admin->name ?? $item->admin->username }}</span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-3 group-hover:text-primary-600 transition line-clamp-2">
                                    {{ $item->judul }}
                                </h3>

                                {{-- Excerpt --}}
                                <p class="text-gray-600 mb-3 sm:mb-4 line-clamp-3 text-sm sm:text-base">
                                    {{ $item->excerpt ?? Str::limit(strip_tags($item->konten), 120) }}
                                </p>

                                {{-- Read More --}}
                                <a 
                                    href="{{ route('berita.show', $item->slug) }}" 
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
                    {{ $berita->withQueryString()->links() }}
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
<section class="py-8 sm:py-12 md:py-16 bg-linear-to-r from-primary-600 to-primary-700">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center text-white scroll-reveal">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4">
                Punya Informasi atau Berita?
            </h2>
            <p class="text-base sm:text-lg text-primary-100 mb-6 sm:mb-8 px-4">
                Bagikan informasi atau kegiatan di desa Anda kepada kami
            </p>
            <a 
                href="https://wa.me/6283114796959?text=Halo,%20saya%20ingin%20berbagi%20informasi%20berita%20desa" 
                target="_blank"
                class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-600 rounded-lg hover:bg-primary-50 transition font-bold text-base sm:text-lg shadow-lg"
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

@push('scripts')
<script>
function searchAutocomplete() {
    return {
        searchQuery: '{{ request("search") }}',
        suggestions: [],
        showSuggestions: false,
        
        async fetchSuggestions() {
            if (this.searchQuery.length < 2) {
                this.suggestions = [];
                return;
            }
            
            try {
                const response = await fetch(`{{ route('berita.autocomplete') }}?q=${encodeURIComponent(this.searchQuery)}`);
                this.suggestions = await response.json();
                this.showSuggestions = this.suggestions.length > 0;
            } catch (error) {
                console.error('Autocomplete error:', error);
                this.suggestions = [];
            }
        }
    }
}
</script>

<style>
/* Scroll-triggered animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.scroll-reveal-stagger {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.scroll-reveal-stagger.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
// Scroll-triggered animation observer
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-reveal classes
    document.querySelectorAll('.scroll-reveal, .scroll-reveal-stagger').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush
