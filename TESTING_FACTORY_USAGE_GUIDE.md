# Factory Usage Guide

## Overview
This guide explains how to use model factories for testing in the Web Desa Warurejo application.

## What are Factories?

Factories are blueprints for creating test data. They allow you to:
- Generate realistic test data quickly
- Create consistent data across tests
- Use state methods for specific scenarios
- Build complex data relationships easily

## Available Factories

### 1. AdminFactory

**Basic Usage:**
```php
use App\Models\Admin;

// Create one admin
$admin = Admin::factory()->create();

// Create multiple admins
$admins = Admin::factory()->count(5)->create();

// Create without saving to database
$admin = Admin::factory()->make();
```

**With Custom Email:**
```php
$admin = Admin::factory()
    ->withEmail('admin@example.com')
    ->create();
```

**With Custom Password:**
```php
$admin = Admin::factory()
    ->withPassword('secretpassword')
    ->create();
```

**Override Attributes:**
```php
$admin = Admin::factory()->create([
    'name' => 'John Doe',
    'phone' => '08123456789',
]);
```

---

### 2. BeritaFactory

**Basic Usage:**
```php
use App\Models\Berita;
use App\Models\Admin;

// Create berita with random admin
$berita = Berita::factory()->create();

// Create berita for specific admin
$admin = Admin::factory()->create();
$berita = Berita::factory()
    ->for($admin)
    ->create();
```

**Published Berita:**
```php
// Create published berita (status = published, has published_at)
$berita = Berita::factory()
    ->published()
    ->create();

// Create multiple published berita
$beritas = Berita::factory()
    ->published()
    ->count(10)
    ->create();
```

**Draft Berita:**
```php
// Create draft berita (status = draft, published_at = null)
$berita = Berita::factory()
    ->draft()
    ->create();
```

**Popular Berita:**
```php
// Create popular berita (views > 1000)
$berita = Berita::factory()
    ->popular()
    ->create();
```

**Combine States:**
```php
// Published and popular berita
$berita = Berita::factory()
    ->published()
    ->popular()
    ->create();
```

**Custom Attributes:**
```php
$berita = Berita::factory()
    ->published()
    ->create([
        'judul' => 'Custom Title',
        'views' => 500,
    ]);
```

**Real-World Examples:**
```php
// Create 10 published berita for testing homepage
$latestBerita = Berita::factory()
    ->for($admin)
    ->published()
    ->count(10)
    ->create();

// Create draft berita for testing admin dashboard
$drafts = Berita::factory()
    ->for($admin)
    ->draft()
    ->count(5)
    ->create();

// Create popular berita for testing trending section
$trending = Berita::factory()
    ->published()
    ->popular()
    ->count(3)
    ->create();
```

---

### 3. PotensiDesaFactory

**Basic Usage:**
```php
use App\Models\PotensiDesa;

// Create active potensi
$potensi = PotensiDesa::factory()->create();

// Create multiple potensi
$potensiList = PotensiDesa::factory()->count(10)->create();
```

**Inactive Potensi:**
```php
$potensi = PotensiDesa::factory()
    ->inactive()
    ->create();
```

**Specific Category:**
```php
use App\Models\PotensiDesa;

// Pertanian
$pertanian = PotensiDesa::factory()
    ->kategori(PotensiDesa::KATEGORI_PERTANIAN)
    ->create();

// Wisata
$wisata = PotensiDesa::factory()
    ->kategori(PotensiDesa::KATEGORI_WISATA)
    ->create();

// Kerajinan
$kerajinan = PotensiDesa::factory()
    ->kategori(PotensiDesa::KATEGORI_KERAJINAN)
    ->create();
```

**Available Categories:**
- `PotensiDesa::KATEGORI_PERTANIAN` - "Pertanian"
- `PotensiDesa::KATEGORI_PERIKANAN` - "Perikanan"
- `PotensiDesa::KATEGORI_PETERNAKAN` - "Peternakan"
- `PotensiDesa::KATEGORI_KERAJINAN` - "Kerajinan"
- `PotensiDesa::KATEGORI_WISATA` - "Wisata"
- `PotensiDesa::KATEGORI_UMKM` - "UMKM"
- `PotensiDesa::KATEGORI_LAINNYA` - "Lainnya"

**Real-World Examples:**
```php
// Create potensi for each category
$categories = [
    PotensiDesa::KATEGORI_PERTANIAN,
    PotensiDesa::KATEGORI_WISATA,
    PotensiDesa::KATEGORI_UMKM,
];

foreach ($categories as $kategori) {
    PotensiDesa::factory()
        ->kategori($kategori)
        ->count(3)
        ->create();
}

// Create featured potensi
$featured = PotensiDesa::factory()
    ->kategori(PotensiDesa::KATEGORI_WISATA)
    ->create([
        'nama' => 'Air Terjun Indah',
        'urutan' => 1,
    ]);

// Create inactive potensi for testing filters
$inactive = PotensiDesa::factory()
    ->inactive()
    ->count(5)
    ->create();
```

---

### 4. GaleriFactory

**Basic Usage:**
```php
use App\Models\Galeri;
use App\Models\Admin;

// Create galeri with random admin
$galeri = Galeri::factory()->create();

// Create galeri for specific admin
$admin = Admin::factory()->create();
$galeri = Galeri::factory()
    ->for($admin)
    ->create();
```

**Inactive Galeri:**
```php
$galeri = Galeri::factory()
    ->inactive()
    ->create();
```

**Specific Category:**
```php
use App\Models\Galeri;

// Kegiatan
$kegiatan = Galeri::factory()
    ->kategori(Galeri::KATEGORI_KEGIATAN)
    ->create();

// Pembangunan
$pembangunan = Galeri::factory()
    ->kategori(Galeri::KATEGORI_PEMBANGUNAN)
    ->create();

// Budaya
$budaya = Galeri::factory()
    ->kategori(Galeri::KATEGORI_BUDAYA)
    ->create();

// Lainnya
$lainnya = Galeri::factory()
    ->kategori(Galeri::KATEGORI_LAINNYA)
    ->create();
```

**Recent Photos:**
```php
// Create galeri from last 7 days
$recent = Galeri::factory()
    ->recent()
    ->count(10)
    ->create();
```

**Available Categories:**
- `Galeri::KATEGORI_KEGIATAN` - "Kegiatan"
- `Galeri::KATEGORI_PEMBANGUNAN` - "Pembangunan"
- `Galeri::KATEGORI_BUDAYA` - "Budaya"
- `Galeri::KATEGORI_LAINNYA` - "Lainnya"

**Combine States:**
```php
// Recent kegiatan photos
$recentKegiatan = Galeri::factory()
    ->kategori(Galeri::KATEGORI_KEGIATAN)
    ->recent()
    ->count(5)
    ->create();
```

**Real-World Examples:**
```php
// Create galeri for homepage (recent active items)
$homepage = Galeri::factory()
    ->for($admin)
    ->recent()
    ->count(6)
    ->create();

// Create galeri for each category
$categories = [
    Galeri::KATEGORI_KEGIATAN,
    Galeri::KATEGORI_PEMBANGUNAN,
    Galeri::KATEGORI_BUDAYA,
];

foreach ($categories as $kategori) {
    Galeri::factory()
        ->for($admin)
        ->kategori($kategori)
        ->count(4)
        ->create();
}

// Create inactive galeri for testing filters
$inactive = Galeri::factory()
    ->inactive()
    ->count(3)
    ->create();
```

---

## Common Patterns

### Pattern 1: Create Related Data
```php
// Create admin with berita
$admin = Admin::factory()
    ->has(Berita::factory()->count(5))
    ->create();

// Create admin with galeri
$admin = Admin::factory()
    ->has(Galeri::factory()->count(10))
    ->create();
```

### Pattern 2: Test Data Setup
```php
public function test_homepage_displays_content(): void
{
    // Arrange
    $admin = Admin::factory()->create();
    
    $berita = Berita::factory()
        ->for($admin)
        ->published()
        ->count(5)
        ->create();
    
    $potensi = PotensiDesa::factory()
        ->count(6)
        ->create();
    
    $galeri = Galeri::factory()
        ->for($admin)
        ->recent()
        ->count(8)
        ->create();
    
    // Act
    $response = $this->get(route('home'));
    
    // Assert
    $response->assertStatus(200);
    $response->assertSee($berita->first()->judul);
}
```

### Pattern 3: Bulk Data Generation
```php
// Seed database for manual testing
public function run(): void
{
    $admin = Admin::factory()->create([
        'email' => 'admin@warurejo.id',
        'password' => Hash::make('password'),
    ]);
    
    // Create 50 published berita
    Berita::factory()
        ->for($admin)
        ->published()
        ->count(50)
        ->create();
    
    // Create 10 draft berita
    Berita::factory()
        ->for($admin)
        ->draft()
        ->count(10)
        ->create();
    
    // Create potensi for each category
    foreach (PotensiDesa::getAllKategori() as $kategori) {
        PotensiDesa::factory()
            ->kategori($kategori)
            ->count(5)
            ->create();
    }
    
    // Create galeri for each category
    foreach (Galeri::getAllKategori() as $kategori) {
        Galeri::factory()
            ->for($admin)
            ->kategori($kategori)
            ->count(10)
            ->create();
    }
}
```

### Pattern 4: State Combinations
```php
// Create various states for comprehensive testing
$published = Berita::factory()->published()->count(10)->create();
$drafts = Berita::factory()->draft()->count(5)->create();
$popular = Berita::factory()->published()->popular()->count(3)->create();

$active = PotensiDesa::factory()->count(15)->create();
$inactive = PotensiDesa::factory()->inactive()->count(5)->create();

$recentGaleri = Galeri::factory()->recent()->count(20)->create();
$oldGaleri = Galeri::factory()->create(['tanggal' => now()->subMonths(6)]);
```

---

## Advanced Usage

### Create Specific Date Ranges
```php
// Berita from last month
$lastMonth = Berita::factory()
    ->published()
    ->create([
        'published_at' => now()->subMonth(),
    ]);

// Galeri from specific date
$newYear = Galeri::factory()
    ->create([
        'tanggal' => now()->startOfYear(),
    ]);
```

### Create with Relationships
```php
// Create admin with 10 published and 5 draft berita
$admin = Admin::factory()
    ->has(
        Berita::factory()
            ->published()
            ->count(10),
        'berita'
    )
    ->has(
        Berita::factory()
            ->draft()
            ->count(5),
        'berita'
    )
    ->create();
```

### Custom Sequences
```php
// Create berita with incremental views
$beritas = Berita::factory()
    ->count(10)
    ->sequence(fn ($sequence) => [
        'views' => ($sequence->index + 1) * 100,
    ])
    ->create();

// Create potensi with specific order
$potensiList = PotensiDesa::factory()
    ->count(5)
    ->sequence(fn ($sequence) => [
        'urutan' => $sequence->index + 1,
        'nama' => "Potensi " . ($sequence->index + 1),
    ])
    ->create();
```

---

## Tips & Best Practices

### 1. Use RefreshDatabase Trait
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_something(): void
    {
        // Database is clean and empty
        $admin = Admin::factory()->create();
        // ...
    }
}
```

### 2. Create Only What You Need
```php
// ❌ Bad - creates unnecessary data
Admin::factory()->count(100)->create();
Berita::factory()->count(1000)->create();

// ✅ Good - create minimal data for test
$admin = Admin::factory()->create();
$berita = Berita::factory()->for($admin)->count(3)->create();
```

### 3. Use make() for Non-Persisted Data
```php
// Use make() when you don't need to save to database
$admin = Admin::factory()->make(); // Not saved
$admin = Admin::factory()->create(); // Saved to database
```

### 4. Leverage State Methods
```php
// ❌ Bad - manual attribute setting
$berita = Berita::factory()->create([
    'status' => 'published',
    'published_at' => now(),
]);

// ✅ Good - use state method
$berita = Berita::factory()->published()->create();
```

### 5. Create Test Helpers
```php
// tests/Helpers.php
trait TestHelpers
{
    protected function createAdmin(): Admin
    {
        return Admin::factory()->create();
    }
    
    protected function createPublishedBerita(int $count = 1): Collection
    {
        return Berita::factory()
            ->for($this->createAdmin())
            ->published()
            ->count($count)
            ->create();
    }
}

// Use in tests
class BeritaTest extends TestCase
{
    use RefreshDatabase, TestHelpers;
    
    public function test_list_berita(): void
    {
        $beritas = $this->createPublishedBerita(10);
        // ...
    }
}
```

---

## Troubleshooting

### Issue: Unique Constraint Violation
```php
// Problem: Slug must be unique
$berita1 = Berita::factory()->create(['judul' => 'Test']);
$berita2 = Berita::factory()->create(['judul' => 'Test']); // Error!

// Solution: Factories automatically add unique suffix
$berita1 = Berita::factory()->create(); // slug: test-1234
$berita2 = Berita::factory()->create(); // slug: test-5678
```

### Issue: Foreign Key Constraint
```php
// Problem: No admin_id provided
$berita = Berita::factory()->create(); // Works - auto-creates admin

// Explicit admin creation
$admin = Admin::factory()->create();
$berita = Berita::factory()->for($admin)->create();
```

### Issue: Random Failures
```php
// Problem: Tests fail randomly due to data variations
$berita = Berita::factory()->create(); // Random status/views

// Solution: Use specific states or attributes
$berita = Berita::factory()
    ->published()
    ->create(['views' => 100]);
```

---

## Examples from Real Tests

### Example 1: HomePage Test
```php
public function test_homepage_displays_latest_berita(): void
{
    $admin = Admin::factory()->create();
    
    $berita = Berita::factory()
        ->for($admin)
        ->published()
        ->count(5)
        ->create();
    
    $response = $this->get(route('home'));
    
    $response->assertStatus(200);
    $response->assertSee($berita->first()->judul);
}
```

### Example 2: Berita Filter Test
```php
public function test_berita_index_does_not_display_draft_articles(): void
{
    $admin = Admin::factory()->create();
    
    $published = Berita::factory()
        ->for($admin)
        ->published()
        ->create(['judul' => 'Published Article']);
    
    $draft = Berita::factory()
        ->for($admin)
        ->draft()
        ->create(['judul' => 'Draft Article']);
    
    $response = $this->get(route('berita.index'));
    
    $response->assertSee('Published Article');
    $response->assertDontSee('Draft Article');
}
```

### Example 3: Service Test
```php
public function test_create_berita_sets_published_at_for_published_status(): void
{
    Cache::flush();
    
    $admin = Admin::factory()->create();
    
    $data = [
        'admin_id' => $admin->id,
        'judul' => 'Test Berita',
        'ringkasan' => 'Summary',
        'konten' => 'Content',
        'status' => 'published',
    ];
    
    $berita = $this->beritaService->createBerita($data);
    
    $this->assertNotNull($berita->published_at);
}
```

---

## Conclusion

Factories make testing easier by:
- ✅ Generating realistic test data
- ✅ Reducing boilerplate code
- ✅ Providing consistent data structures
- ✅ Enabling state-based testing
- ✅ Supporting complex relationships

**Remember:**
- Use `create()` when you need database records
- Use `make()` when you just need objects
- Use state methods for specific scenarios
- Use `count()` to create multiple items
- Use `for()` to set relationships

---

**Generated:** 2025-01-XX  
**Last Updated:** Testing Implementation - Week 4
