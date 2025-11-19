# Advanced Search & Filters - Documentation

## Overview

Sistem pencarian dan filter lanjutan untuk berita desa yang memungkinkan pengunjung menemukan konten dengan lebih mudah dan cepat.

**Status:** ✅ IMPLEMENTED  
**Version:** 1.0  
**Date:** 17 November 2025

---

## Features

### 1. Full-Text Search
Pencarian teks lengkap di beberapa field:
- **Judul** (title)
- **Ringkasan** (summary/excerpt)
- **Konten** (full content)

### 2. Date Range Filter
Filter berdasarkan tanggal publikasi:
- **Tanggal Mulai** (date_from)
- **Tanggal Akhir** (date_to)
- Support untuk rentang tanggal custom

### 3. Sort Options
Pengurutan hasil pencarian:
- **Terbaru** (latest) - Default, urutkan dari yang terbaru
- **Terlama** (oldest) - Urutkan dari yang terlama
- **Terpopuler** (popular) - Urutkan berdasarkan jumlah views

### 4. Search Autocomplete
Saran pencarian real-time:
- Muncul setelah mengetik 2+ karakter
- Debounce 300ms untuk performa
- Menampilkan 5 saran teratas
- Direct link ke artikel

---

## Usage

### Basic Search

**URL Pattern:**
```
/berita?search={keyword}
```

**Example:**
```
/berita?search=pembangunan
/berita?search=kegiatan desa
```

**Behavior:**
- Search di judul, ringkasan, dan konten
- Case-insensitive
- Partial match (LIKE %keyword%)

### Date Range Filter

**URL Pattern:**
```
/berita?date_from={YYYY-MM-DD}&date_to={YYYY-MM-DD}
```

**Example:**
```
# Berita bulan ini
/berita?date_from=2025-11-01&date_to=2025-11-30

# Berita tahun ini
/berita?date_from=2025-01-01&date_to=2025-12-31

# Hanya date_from (dari tanggal tertentu)
/berita?date_from=2025-01-01

# Hanya date_to (sampai tanggal tertentu)
/berita?date_to=2025-11-17
```

**Behavior:**
- Filter berdasarkan field `published_at`
- Inclusive (termasuk tanggal yang dipilih)
- Validasi: max date = today

### Sort Options

**URL Pattern:**
```
/berita?sort={option}
```

**Options:**
- `latest` - Terbaru (default)
- `oldest` - Terlama
- `popular` - Terpopuler

**Example:**
```
# Berita terpopuler
/berita?sort=popular

# Berita terlama
/berita?sort=oldest
```

### Combined Filters

**Example:**
```
# Search + date range + sort
/berita?search=desa&date_from=2025-01-01&sort=popular

# All filters
/berita?search=pembangunan&date_from=2025-01-01&date_to=2025-11-17&sort=latest
```

---

## API Endpoints

### Autocomplete Suggestions

**Endpoint:** `GET /berita/autocomplete`

**Parameters:**
- `q` (required) - Search query (min 2 characters)

**Request Example:**
```
GET /berita/autocomplete?q=pemb
```

**Response Example:**
```json
[
    {
        "title": "Pembangunan Jalan Desa Tahap 2",
        "url": "http://localhost/berita/pembangunan-jalan-desa-tahap-2"
    },
    {
        "title": "Pemberdayaan UMKM Desa Warurejo",
        "url": "http://localhost/berita/pemberdayaan-umkm-desa-warurejo"
    }
]
```

**Response Fields:**
- `title` - Judul berita
- `url` - Direct link ke detail berita

**Rate Limiting:**
- No explicit limit (rely on debounce in frontend)
- Consider adding throttle if needed

---

## Implementation Details

### Backend Architecture

#### 1. Controller Layer
**File:** `app/Http/Controllers/Public/BeritaController.php`

```php
public function index(Request $request)
{
    $perPage = 12;
    
    // Get filter parameters
    $search = $request->get('search');
    $dateFrom = $request->get('date_from');
    $dateTo = $request->get('date_to');
    $sortBy = $request->get('sort', 'latest');
    
    // Apply filters if any parameter is set
    if ($search || $dateFrom || $dateTo || $sortBy !== 'latest') {
        $berita = $this->beritaService->searchWithFilters([
            'search' => $search,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'sort' => $sortBy
        ], $perPage);
    } else {
        $berita = $this->beritaService->getPublishedBerita($perPage);
    }
    
    return view('public.berita.index', compact('berita', 'seoData'));
}

public function autocomplete(Request $request)
{
    $query = $request->get('q', '');
    
    if (strlen($query) < 2) {
        return response()->json([]);
    }
    
    $suggestions = $this->beritaService->getSearchSuggestions($query, 5);
    
    return response()->json($suggestions);
}
```

#### 2. Service Layer
**File:** `app/Services/BeritaService.php`

```php
public function searchWithFilters(array $filters, $perPage = 12)
{
    return $this->beritaRepository->advancedSearch($filters, $perPage);
}

public function getSearchSuggestions($query, $limit = 5)
{
    return $this->beritaRepository->getSearchSuggestions($query, $limit);
}
```

#### 3. Repository Layer
**File:** `app/Repositories/BeritaRepository.php`

```php
public function advancedSearch(array $filters, $perPage = 12)
{
    $query = $this->model->with('admin')->published();
    
    // Search by keyword
    if (!empty($filters['search'])) {
        $keyword = $filters['search'];
        $query->where(function($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('ringkasan', 'like', "%{$keyword}%")
              ->orWhere('konten', 'like', "%{$keyword}%");
        });
    }
    
    // Filter by date range
    if (!empty($filters['date_from'])) {
        $query->whereDate('published_at', '>=', $filters['date_from']);
    }
    
    if (!empty($filters['date_to'])) {
        $query->whereDate('published_at', '<=', $filters['date_to']);
    }
    
    // Sort by
    $sortBy = $filters['sort'] ?? 'latest';
    switch ($sortBy) {
        case 'popular':
            $query->orderBy('views', 'desc');
            break;
        case 'oldest':
            $query->oldest();
            break;
        case 'latest':
        default:
            $query->latest();
            break;
    }
    
    return $query->paginate($perPage);
}

public function getSearchSuggestions($query, $limit = 5)
{
    return $this->model
        ->published()
        ->where('judul', 'like', "%{$query}%")
        ->select('judul', 'slug')
        ->limit($limit)
        ->get()
        ->map(function($berita) {
            return [
                'title' => $berita->judul,
                'url' => route('berita.show', $berita->slug)
            ];
        });
}
```

### Frontend Implementation

#### Alpine.js Component
**File:** `resources/views/public/berita/index.blade.php`

```javascript
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
                const response = await fetch(
                    `{{ route('berita.autocomplete') }}?q=${encodeURIComponent(this.searchQuery)}`
                );
                this.suggestions = await response.json();
                this.showSuggestions = this.suggestions.length > 0;
            } catch (error) {
                console.error('Autocomplete error:', error);
                this.suggestions = [];
            }
        }
    }
}
```

#### Search Form HTML

```blade
<form method="GET" action="{{ route('berita.index') }}" x-data="searchAutocomplete()">
    
    {{-- Search with Autocomplete --}}
    <div class="relative">
        <input 
            type="text" 
            name="search" 
            x-model="searchQuery"
            @input.debounce.300ms="fetchSuggestions()"
            @focus="showSuggestions = true"
            @click.away="showSuggestions = false"
            placeholder="Cari berita..."
            class="w-full px-4 py-3 border rounded-lg"
        >
        
        {{-- Autocomplete Dropdown --}}
        <div 
            x-show="showSuggestions && suggestions.length > 0"
            x-transition
            class="absolute w-full mt-1 bg-white border rounded-lg shadow-lg"
        >
            <template x-for="suggestion in suggestions">
                <a :href="suggestion.url">
                    <span x-text="suggestion.title"></span>
                </a>
            </template>
        </div>
    </div>
    
    {{-- Date Range --}}
    <input type="date" name="date_from" value="{{ request('date_from') }}">
    <input type="date" name="date_to" value="{{ request('date_to') }}">
    
    {{-- Sort --}}
    <select name="sort">
        <option value="latest">Terbaru</option>
        <option value="oldest">Terlama</option>
        <option value="popular">Terpopuler</option>
    </select>
    
    {{-- Submit --}}
    <button type="submit">Terapkan Filter</button>
    
    {{-- Reset --}}
    <a href="{{ route('berita.index') }}">Reset Filter</a>
</form>
```

---

## Performance Optimization

### 1. Database Indexes

**Recommended Indexes:**
```sql
-- Index on published_at for date filtering
ALTER TABLE berita ADD INDEX idx_berita_published_at (published_at);

-- Index on views for popularity sorting
ALTER TABLE berita ADD INDEX idx_berita_views (views);

-- Index on status for published filtering
ALTER TABLE berita ADD INDEX idx_berita_status (status);

-- Composite index for common queries
ALTER TABLE berita ADD INDEX idx_berita_status_published (status, published_at);
```

### 2. Query Optimization

**Eager Loading:**
```php
// ✅ GOOD - Eager load admin to prevent N+1
$query->with('admin');

// ❌ BAD - N+1 problem
$query->get()->each(function($berita) {
    echo $berita->admin->nama; // Extra query per item
});
```

**Pagination:**
```php
// Use withQueryString() to maintain filters
$berita->withQueryString()->links()
```

### 3. Frontend Optimization

**Debouncing:**
```javascript
// Wait 300ms before sending request
@input.debounce.300ms="fetchSuggestions()"
```

**Minimum Length:**
```javascript
// Only search after 2+ characters
if (this.searchQuery.length < 2) {
    return;
}
```

---

## Testing

### Manual Testing Checklist

**Search:**
- [ ] Search by title
- [ ] Search by content
- [ ] Search with special characters
- [ ] Empty search
- [ ] Very long search query

**Date Range:**
- [ ] Filter by start date only
- [ ] Filter by end date only
- [ ] Filter by both dates
- [ ] Invalid date format
- [ ] Future dates (should be blocked)

**Sort:**
- [ ] Sort by latest
- [ ] Sort by oldest
- [ ] Sort by popular
- [ ] Default sort (no parameter)

**Autocomplete:**
- [ ] Type 1 character (should not trigger)
- [ ] Type 2+ characters (should show suggestions)
- [ ] Click suggestion (should navigate)
- [ ] Click away (should close dropdown)
- [ ] No results found
- [ ] Network error handling

**Pagination:**
- [ ] Navigate between pages
- [ ] Query strings preserved
- [ ] Page numbers correct
- [ ] Empty state on no results

**Combined:**
- [ ] All filters together
- [ ] Reset filters button
- [ ] Active filters display
- [ ] URL reflects filters

### Automated Testing

**Feature Test Example:**
```php
// tests/Feature/BeritaSearchTest.php
public function test_can_search_berita_by_keyword()
{
    Berita::factory()->create(['judul' => 'Pembangunan Jalan Desa']);
    Berita::factory()->create(['judul' => 'Kegiatan Gotong Royong']);
    
    $response = $this->get(route('berita.index', ['search' => 'Pembangunan']));
    
    $response->assertStatus(200);
    $response->assertSee('Pembangunan Jalan Desa');
    $response->assertDontSee('Kegiatan Gotong Royong');
}

public function test_can_filter_by_date_range()
{
    Berita::factory()->create([
        'judul' => 'Berita Lama',
        'published_at' => '2025-01-01'
    ]);
    
    Berita::factory()->create([
        'judul' => 'Berita Baru',
        'published_at' => '2025-11-01'
    ]);
    
    $response = $this->get(route('berita.index', [
        'date_from' => '2025-11-01',
        'date_to' => '2025-11-30'
    ]));
    
    $response->assertStatus(200);
    $response->assertSee('Berita Baru');
    $response->assertDontSee('Berita Lama');
}

public function test_autocomplete_returns_suggestions()
{
    Berita::factory()->create(['judul' => 'Pembangunan Jalan']);
    Berita::factory()->create(['judul' => 'Pemberdayaan UMKM']);
    
    $response = $this->get(route('berita.autocomplete', ['q' => 'pemb']));
    
    $response->assertStatus(200);
    $response->assertJsonCount(2);
    $response->assertJsonFragment(['title' => 'Pembangunan Jalan']);
}
```

---

## User Guide

### For Website Visitors

#### Basic Search
1. Masuk ke halaman Berita
2. Ketik kata kunci di kotak pencarian
3. Klik "Terapkan Filter" atau tekan Enter

#### Date Range Filter
1. Klik kalender "Tanggal Mulai" dan pilih tanggal
2. Klik kalender "Tanggal Akhir" dan pilih tanggal
3. Klik "Terapkan Filter"

#### Sort Results
1. Pilih opsi dari dropdown "Urutkan"
   - Terbaru: Berita paling baru di atas
   - Terlama: Berita paling lama di atas
   - Terpopuler: Berita dengan views terbanyak di atas
2. Klik "Terapkan Filter"

#### Using Autocomplete
1. Mulai mengetik di kotak pencarian
2. Tunggu saran muncul (setelah 2+ karakter)
3. Klik salah satu saran untuk langsung ke artikel

#### Reset Filters
Klik tombol "Reset Filter" untuk menghapus semua filter dan kembali ke tampilan default.

### For Administrators

#### Content Best Practices
1. **Judul yang Jelas**: Gunakan judul deskriptif untuk memudahkan pencarian
2. **Ringkasan Informatif**: Isi ringkasan dengan info penting
3. **Konten Berkualitas**: Tulis konten lengkap dan relevan
4. **Publikasi Konsisten**: Publikasikan berita secara teratur

#### SEO Tips
1. Gunakan kata kunci relevan di judul
2. Tulis meta description yang menarik
3. Update berita lama jika ada informasi baru
4. Tambahkan internal links ke berita terkait

---

## Troubleshooting

### Issue: Autocomplete tidak muncul

**Possible Causes:**
1. JavaScript error di console
2. Route tidak terdaftar
3. CSRF token expired

**Solutions:**
1. Buka Developer Console (F12) dan cek error
2. Verify route: `php artisan route:list | grep autocomplete`
3. Refresh halaman untuk token baru

### Issue: Search tidak menemukan hasil

**Possible Causes:**
1. Tidak ada berita dengan status "published"
2. Kata kunci salah eja
3. Database empty

**Solutions:**
1. Cek status berita di admin panel
2. Coba kata kunci berbeda
3. Seed database dengan sample data

### Issue: Date filter tidak bekerja

**Possible Causes:**
1. Format tanggal salah
2. Timezone mismatch
3. Field published_at NULL

**Solutions:**
1. Gunakan format YYYY-MM-DD
2. Check Laravel timezone config
3. Pastikan semua berita punya published_at

### Issue: Pagination kehilangan filter

**Possible Causes:**
1. Missing `withQueryString()` di pagination
2. Form tidak preserve values

**Solutions:**
1. Update pagination: `$berita->withQueryString()->links()`
2. Add `value="{{ request('search') }}"` to inputs

---

## Future Enhancements

### Planned Features

1. **Category Filter**
   - Add kategori field to berita table
   - Filter by category
   - Multiple category selection

2. **Tag System**
   - Implement tag functionality
   - Filter by tags
   - Tag cloud display

3. **Advanced Sorting**
   - Sort by relevance score
   - Sort by comments count
   - Custom user preferences

4. **Search Analytics**
   - Track popular searches
   - Show trending topics
   - Search suggestions based on history

5. **Saved Searches**
   - Allow users to save filter combinations
   - Email notifications for saved searches
   - RSS feed for specific filters

6. **Faceted Search**
   - Multiple filter categories
   - Filter count display
   - Dynamic filter options

---

## Support

**Questions or Issues?**
- Email: adminwarurejo@gmail.com
- Documentation: Check README.md
- Laravel Docs: https://laravel.com/docs/11.x

---

## Changelog

### Version 1.0 (17 November 2025)
- ✅ Initial implementation
- ✅ Full-text search
- ✅ Date range filter
- ✅ Sort options
- ✅ Search autocomplete
- ✅ Active filters display
- ✅ Query string preservation
- ✅ Responsive design

---

**Last Updated:** 17 November 2025  
**Version:** 1.0  
**Status:** ✅ Production Ready

**END OF DOCUMENT**
