# 📋 Perbaikan Tampilan Publik - Web Desa Warurejo

**Tanggal**: 24 November 2025  
**Status**: 🔴 Belum Diimplementasi  
**Prioritas**: HIGH - Urgent

---

## 🎯 Tujuan Perbaikan

Meningkatkan kualitas tampilan website publik agar:
- ✅ **Responsive** - Sempurna di semua perangkat (mobile, tablet, desktop)
- ✅ **Interaktif** - Ada animasi dan efek, tapi tidak berlebihan untuk user awam
- ✅ **Dynamic** - Admin bisa edit konten tanpa coding
- ✅ **Akurat** - Data counter sesuai dengan data sebenarnya
- ✅ **Professional** - Tampilan modern tapi tetap mudah dipahami

---

## 📊 Ringkasan Masalah & Solusi

| No | Bagian | Masalah | Solusi | Status |
|----|--------|---------|--------|--------|
| 1 | **Sambutan & Foto** | Hardcoded, tidak bisa edit admin | Tambah field database + CRUD | 🔴 TODO |
| 2 | **Data Counter** | Angka tidak sesuai (10 upload tapi tampil 6-8) | Fix query dengan filter status | 🔴 TODO |
| 3 | **Profil Desa** | Kurang responsive & interaktif | Redesign responsive + animasi | 🔴 TODO |
| 4 | **Informasi** | Kurang responsive & interaktif | Redesign responsive + animasi | 🔴 TODO |
| 5 | **Publikasi** | Kurang responsive & interaktif | Redesign responsive + animasi | 🔴 TODO |

---

## 🔴 MASALAH 1: Sambutan & Foto Kepala Desa (CRUD Admin)

### Kondisi Sekarang ❌
```blade
<!-- File: home.blade.php - Line 58-120 -->
<h2>Selamat Datang</h2>  <!-- ❌ HARDCODED -->

<img src="{{ asset('images/pemandangan-alam.jpg') }}" />  <!-- ❌ HARDCODED -->

<div class="text-gray-700">
    <p>Assalamu'alaikum warahmatullahi wabarakatuh,</p>
    <p>Salam sejahtera bagi kita semua,</p>
    <p>Dengan penuh rasa syukur...</p>  <!-- ❌ HARDCODED -->
</div>
```

**Masalah**: Admin tidak bisa mengubah kata sambutan dan foto. Harus edit file `.blade.php` (butuh programmer).

---

### Solusi ✅

#### Step 1: Tambah Field Database

**File Baru**: `database/migrations/2025_11_24_add_sambutan_to_profil_desa.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            // Field untuk sambutan kepala desa
            $table->string('foto_sambutan')->nullable()->after('gambar_kantor');
            $table->string('judul_sambutan')->nullable()->after('foto_sambutan');
            $table->longText('teks_sambutan')->nullable()->after('judul_sambutan');
            $table->string('nama_kepala_desa')->nullable()->after('teks_sambutan');
        });
    }

    public function down(): void
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            $table->dropColumn(['foto_sambutan', 'judul_sambutan', 'teks_sambutan', 'nama_kepala_desa']);
        });
    }
};
```

**Jalankan**:
```bash
php artisan migrate
```

---

#### Step 2: Update Model ProfilDesa

**File**: `app/Models/ProfilDesa.php`

**Tambahkan di array `$fillable`**:
```php
protected $fillable = [
    'nama_desa',
    'kecamatan',
    // ... field lain ...
    'foto_sambutan',        // ✅ TAMBAH
    'judul_sambutan',       // ✅ TAMBAH
    'teks_sambutan',        // ✅ TAMBAH
    'nama_kepala_desa',     // ✅ TAMBAH
];

// Tambahkan accessor untuk foto sambutan
public function getFotoSambutanUrlAttribute()
{
    return $this->foto_sambutan 
        ? asset('storage/' . $this->foto_sambutan) 
        : asset('images/pemandangan-alam.jpg');
}
```

---

#### Step 3: Update Form Admin (Edit Profil Desa)

**File**: `resources/views/admin/profil-desa/edit.blade.php`

**Tambahkan section baru** (taruh setelah section gambar/logo):

```blade
{{-- ============================================
     SECTION: SAMBUTAN KEPALA DESA
============================================= --}}
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center border-b pb-4">
        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Sambutan Kepala Desa (Halaman Beranda)
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- FOTO SAMBUTAN --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Foto Sambutan
                <span class="text-gray-500 font-normal">(Ditampilkan di halaman beranda)</span>
            </label>
            
            @if($profil->foto_sambutan)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $profil->foto_sambutan) }}" 
                         alt="Foto Sambutan" 
                         class="w-64 h-64 object-cover rounded-lg shadow-md border-4 border-gray-100">
                </div>
            @endif
            
            <input type="file" 
                   name="foto_sambutan" 
                   id="foto_sambutan"
                   accept="image/jpeg,image/jpg,image/png,image/webp"
                   class="block w-full text-sm text-gray-500 
                          file:mr-4 file:py-2 file:px-4 
                          file:rounded-md file:border-0 
                          file:text-sm file:font-semibold 
                          file:bg-primary-50 file:text-primary-700 
                          hover:file:bg-primary-100
                          cursor-pointer">
            
            <p class="text-xs text-gray-500 mt-2">
                📸 Format: JPG, PNG, WEBP | Max: 2MB | Rekomendasi: 800x800px (persegi)
            </p>
            
            @error('foto_sambutan')
                <p class="text-red-500 text-xs mt-1">❌ {{ $message }}</p>
            @enderror
        </div>

        {{-- NAMA KEPALA DESA --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Kepala Desa
                <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nama_kepala_desa" 
                   id="nama_kepala_desa"
                   value="{{ old('nama_kepala_desa', $profil->nama_kepala_desa ?? 'Sunarto') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                          focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                   placeholder="Contoh: Budi Santoso, S.Sos"
                   required>
            
            @error('nama_kepala_desa')
                <p class="text-red-500 text-xs mt-1">❌ {{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- JUDUL SAMBUTAN --}}
    <div class="mt-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Judul Sambutan
            <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="judul_sambutan" 
               id="judul_sambutan"
               value="{{ old('judul_sambutan', $profil->judul_sambutan ?? 'Selamat Datang') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                      focus:ring-2 focus:ring-primary-500 focus:border-transparent"
               placeholder="Contoh: Selamat Datang di Website Desa Warurejo"
               required>
        
        @error('judul_sambutan')
            <p class="text-red-500 text-xs mt-1">❌ {{ $message }}</p>
        @enderror
    </div>

    {{-- TEKS SAMBUTAN --}}
    <div class="mt-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Teks Sambutan
            <span class="text-red-500">*</span>
        </label>
        <textarea name="teks_sambutan" 
                  id="teks_sambutan"
                  rows="12"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                         focus:ring-2 focus:ring-primary-500 focus:border-transparent
                         font-mono text-sm"
                  placeholder="Tulis sambutan kepala desa di sini...&#10;&#10;Tips:&#10;- Mulai dengan salam (Assalamu'alaikum / Salam sejahtera)&#10;- Jelaskan visi desa (3-5 paragraf)&#10;- Tutup dengan salam penutup&#10;- Gunakan bahasa formal tapi ramah"
                  required>{{ old('teks_sambutan', $profil->teks_sambutan ?? '') }}</textarea>
        
        <div class="flex items-start mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-xs text-blue-700">
                <strong>💡 Tips Menulis Sambutan:</strong>
                <ul class="mt-1 ml-4 list-disc">
                    <li>Gunakan 3-5 paragraf (tidak terlalu panjang)</li>
                    <li>Bahasa formal tapi tetap ramah dan mudah dipahami</li>
                    <li>Tekan Enter 2x untuk membuat paragraf baru</li>
                    <li>Sampaikan visi dan harapan untuk kemajuan desa</li>
                </ul>
            </div>
        </div>
        
        @error('teks_sambutan')
            <p class="text-red-500 text-xs mt-1">❌ {{ $message }}</p>
        @enderror
    </div>
</div>
```

---

#### Step 4: Update Controller

**File**: `app/Http/Controllers/Admin/ProfilDesaController.php`

**Update method `update()`**:

```php
public function update(ProfilDesaRequest $request)
{
    try {
        $profil = ProfilDesa::getInstance();
        
        // Ambil semua data text
        $data = $request->only([
            'judul_sambutan',
            'teks_sambutan',
            'nama_kepala_desa',
            // ... field lain yang sudah ada
        ]);
        
        // ✅ UPLOAD FOTO SAMBUTAN
        if ($request->hasFile('foto_sambutan')) {
            // Delete old foto
            if ($profil->foto_sambutan && Storage::disk('public')->exists($profil->foto_sambutan)) {
                Storage::disk('public')->delete($profil->foto_sambutan);
            }
            
            // Upload new foto (800x800 untuk sambutan)
            $data['foto_sambutan'] = $this->imageUploadService->upload(
                $request->file('foto_sambutan'),
                'profil-desa/sambutan',
                800,   // width
                800    // height (square)
            );
        }
        
        // Upload gambar header (jika ada)
        if ($request->hasFile('gambar_header')) {
            if ($profil->gambar_header && Storage::disk('public')->exists($profil->gambar_header)) {
                Storage::disk('public')->delete($profil->gambar_header);
            }
            
            $data['gambar_header'] = $this->imageUploadService->upload(
                $request->file('gambar_header'),
                'profil-desa/header',
                1920,
                null
            );
        }
        
        // Upload struktur organisasi (jika ada)
        if ($request->hasFile('struktur_organisasi')) {
            if ($profil->struktur_organisasi && Storage::disk('public')->exists($profil->struktur_organisasi)) {
                Storage::disk('public')->delete($profil->struktur_organisasi);
            }
            
            $data['struktur_organisasi'] = $this->imageUploadService->upload(
                $request->file('struktur_organisasi'),
                'profil-desa/struktur',
                1920,
                null
            );
        }
        
        // Update database
        $profil->update($data);
        
        // Clear cache
        Cache::forget('profil_desa');
        
        return redirect()
            ->route('admin.profil-desa.edit')
            ->with('success', '✅ Profil desa berhasil diperbarui!');
            
    } catch (\Exception $e) {
        Log::error('Error updating profil desa: ' . $e->getMessage());
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
    }
}
```

---

#### Step 5: Update Validation Request

**File**: `app/Http/Requests/ProfilDesaRequest.php`

**Tambahkan rules**:

```php
public function rules(): array
{
    return [
        // ... rules yang sudah ada ...
        
        // ✅ TAMBAH RULES BARU
        'foto_sambutan' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'judul_sambutan' => 'nullable|string|max:255',
        'teks_sambutan' => 'nullable|string|max:10000',
        'nama_kepala_desa' => 'nullable|string|max:255',
    ];
}

public function messages(): array
{
    return [
        // ... messages yang sudah ada ...
        
        // ✅ TAMBAH MESSAGES BARU
        'foto_sambutan.image' => 'File harus berupa gambar',
        'foto_sambutan.mimes' => 'Format gambar harus: JPG, PNG, atau WEBP',
        'foto_sambutan.max' => 'Ukuran gambar maksimal 2MB',
        'judul_sambutan.max' => 'Judul sambutan maksimal 255 karakter',
        'teks_sambutan.max' => 'Teks sambutan maksimal 10000 karakter',
        'nama_kepala_desa.max' => 'Nama kepala desa maksimal 255 karakter',
    ];
}
```

---

#### Step 6: Update View Public (home.blade.php)

**File**: `resources/views/public/home.blade.php`

**GANTI bagian sambutan (line 58-120) dengan**:

```blade
<!-- Sambutan Kepala Desa - DYNAMIC -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        
        <!-- Judul (Dynamic) -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-2">
                {{ $profil->judul_sambutan ?? 'Selamat Datang' }}
            </h2>
            <div class="w-24 h-1 bg-amber-400 mx-auto mt-4"></div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 items-start">
                
                <!-- Foto (Dynamic) - Mobile: Top, Desktop: Right -->
                <div class="lg:col-span-2 order-1 lg:order-2">
                    <div class="relative h-full max-w-sm mx-auto lg:max-w-none">
                        <!-- Yellow Corner Decorations -->
                        <div class="absolute top-0 right-0 w-12 h-12 border-t-4 border-r-4 border-amber-400 rounded-tr-2xl"></div>
                        <div class="absolute bottom-0 left-0 w-12 h-12 border-b-4 border-l-4 border-amber-400 rounded-bl-2xl"></div>
                        
                        <!-- Photo Container -->
                        <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-2xl h-full min-h-[350px] lg:min-h-[450px] mt-6 mb-6 lg:mt-0 lg:mb-0">
                            <img 
                                src="{{ $profil->foto_sambutan_url }}" 
                                alt="{{ $profil->judul_sambutan ?? 'Sambutan Kepala Desa' }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                    </div>
                </div>

                <!-- Text Content (Dynamic) - Mobile: Bottom, Desktop: Left -->
                <div class="lg:col-span-3 order-2 lg:order-1">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-primary-700 mb-4 text-center lg:text-left">
                        SAMBUTAN KEPALA {{ strtoupper($profil->nama_desa) }}
                    </h3>
                    <div class="w-20 h-1 bg-amber-400 mb-6 mx-auto lg:mx-0"></div>
                    
                    <!-- Teks Sambutan (Dynamic) -->
                    <div class="text-gray-700 space-y-4 text-justify leading-relaxed text-sm md:text-base prose prose-sm md:prose-base max-w-none">
                        @if($profil->teks_sambutan)
                            {!! nl2br(e($profil->teks_sambutan)) !!}
                        @else
                            <p class="font-medium">Assalamu'alaikum warahmatullahi wabarakatuh,</p>
                            <p>Salam sejahtera bagi kita semua,</p>
                            <p>Selamat datang di website resmi Desa {{ $profil->nama_desa }}.</p>
                        @endif
                    </div>

                    <!-- Nama Kepala Desa (Dynamic) -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-lg md:text-xl font-bold text-gray-800">
                            {{ strtoupper($profil->nama_kepala_desa ?? 'KEPALA DESA') }}
                        </p>
                        <p class="text-gray-600">Kepala {{ $profil->nama_desa }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
```

---

### ✅ Hasil Akhir Step 1

Setelah implementasi:
1. ✅ Admin bisa edit **judul sambutan** via dashboard
2. ✅ Admin bisa upload **foto sambutan** via dashboard
3. ✅ Admin bisa edit **teks sambutan** via dashboard
4. ✅ Admin bisa edit **nama kepala desa** via dashboard
5. ✅ Tampilan homepage otomatis update (dynamic)

---

## 🔴 MASALAH 2: Data Counter Tidak Sesuai

### Kondisi Sekarang ❌

```blade
<!-- File: home.blade.php - Line 38-50 -->
<div class="text-4xl font-bold text-primary-600 mb-2">
    {{ $potensi->count() }}           <!-- ❌ SALAH: Hitung data yang sudah di-take(3) -->
</div>

<div class="text-4xl font-bold text-primary-600 mb-2">
    {{ $latest_berita->count() }}     <!-- ❌ SALAH: Hitung data yang sudah di-take(6) -->
</div>

<div class="text-4xl font-bold text-primary-600 mb-2">
    {{ $galeri->count() }}            <!-- ❌ SALAH: Hitung data yang sudah di-take(6) -->
</div>
```

**Masalah**: 
- Admin upload **10 berita** → Counter tampil **6** (karena `$latest_berita->take(6)`)
- Admin upload **10 potensi** → Counter tampil **3** (karena `$potensi->take(3)`)
- Admin upload **10 galeri** → Counter tampil **6** (karena `$galeri->take(6)`)

**Penyebab**: 
Counter menghitung dari collection yang sudah di-limit, bukan dari database total.

---

### Solusi ✅

#### Fix 1: Update Controller - HomeController

**File**: `app/Http/Controllers/Public/HomeController.php`

**GANTI method `index()` dengan**:

```php
public function index()
{
    // Cache profil desa
    $profil = Cache::remember('profil_desa', 86400, function () {
        return ProfilDesa::getInstance();
    });
    
    // ✅ BERITA: Ambil 6 untuk ditampilkan
    $latest_berita = Cache::remember('home.latest_berita', 3600, function () {
        return $this->beritaService->getPublishedBerita(6);
    });
    
    // ✅ POTENSI: Ambil semua yang active (nanti di view di-take(3))
    $potensi = Cache::remember('home.potensi', 3600, function () {
        return PotensiDesa::where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();  // ✅ GET ALL, jangan take() di sini
    });
    
    // ✅ GALERI: Ambil 6 untuk ditampilkan
    $galeri = Cache::remember('home.galeri', 3600, function () {
        return $this->galeriRepository->getActiveGaleri(6);
    });
    
    // ✅ COUNTER TOTAL (untuk stats section)
    $totalPotensi = Cache::remember('home.total_potensi', 3600, function () {
        return PotensiDesa::where('is_active', true)->count();
    });
    
    $totalBerita = Cache::remember('home.total_berita', 3600, function () {
        return Berita::where('status', 'published')->count();
    });
    
    $totalGaleri = Cache::remember('home.total_galeri', 3600, function () {
        return Galeri::where('is_active', true)->count();
    });
    
    // Visitor tracking
    $this->visitorService->trackVisitor();
    $totalVisitors = $this->visitorService->getTotalVisitors();
    
    // SEO Meta
    $seoData = Cache::remember('home.seo_data', 86400, function () use ($profil) {
        return SEOHelper::generateMetaTags([
            'title' => 'Beranda - ' . $profil->nama_desa,
            'description' => "Website resmi {$profil->nama_desa}, {$profil->kecamatan}, {$profil->kabupaten}.",
            'keywords' => "desa warurejo, {$profil->kecamatan}, {$profil->kabupaten}, profil desa",
            'image' => $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png'),
            'type' => 'website'
        ]);
    });
    
    $structuredData = SEOHelper::getOrganizationSchema();

    return view('public.home', compact(
        'profil',
        'latest_berita',
        'potensi',
        'galeri',
        'totalPotensi',      // ✅ TAMBAH
        'totalBerita',       // ✅ TAMBAH
        'totalGaleri',       // ✅ TAMBAH
        'totalVisitors',
        'seoData',
        'structuredData'
    ));
}
```

---

#### Fix 2: Update View - home.blade.php

**File**: `resources/views/public/home.blade.php`

**GANTI Stats Section (line 34-52) dengan**:

```blade
<!-- Stats Section - DATA AKURAT ✅ -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            
            {{-- ✅ COUNTER POTENSI - Query database langsung --}}
            <div class="text-center transform hover:scale-105 transition duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-primary-600 mb-2">
                    {{ $totalPotensi ?? 0 }}
                </div>
                <div class="text-gray-600 font-medium">Potensi Desa</div>
            </div>
            
            {{-- ✅ COUNTER BERITA - Query database langsung --}}
            <div class="text-center transform hover:scale-105 transition duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-primary-600 mb-2">
                    {{ $totalBerita ?? 0 }}
                </div>
                <div class="text-gray-600 font-medium">Berita Terbaru</div>
            </div>
            
            {{-- ✅ COUNTER GALERI - Query database langsung --}}
            <div class="text-center transform hover:scale-105 transition duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-primary-600 mb-2">
                    {{ $totalGaleri ?? 0 }}
                </div>
                <div class="text-gray-600 font-medium">Dokumentasi</div>
            </div>
            
            {{-- ✅ COUNTER PENGUNJUNG --}}
            <div class="text-center transform hover:scale-105 transition duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-3">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold text-primary-600 mb-2">
                    {{ number_format($totalVisitors) }}
                </div>
                <div class="text-gray-600 font-medium">Pengunjung</div>
            </div>
            
        </div>
    </div>
</section>
```

---

### ✅ Hasil Akhir Step 2

Setelah fix:
1. ✅ Admin upload **10 berita** → Counter tampil **10** ✅
2. ✅ Admin upload **10 potensi** → Counter tampil **10** ✅
3. ✅ Admin upload **10 galeri** → Counter tampil **10** ✅
4. ✅ Data akurat sesuai dengan status (published/active)
5. ✅ Bonus: Ada icon dan hover effect untuk interaktif

---

## 🔴 MASALAH 3: Profil Desa (Visi Misi, Sejarah, Struktur) - Kurang Responsive & Interaktif

### Target Pages:
1. **Visi & Misi** - `resources/views/public/profil/visi-misi.blade.php`
2. **Sejarah** - `resources/views/public/profil/sejarah.blade.php`
3. **Struktur Organisasi** - `resources/views/public/profil/struktur-organisasi.blade.php`

### Prinsip Design:
- ✅ **Mobile-first**: Sempurna di HP terlebih dahulu
- ✅ **Card-based**: Menggunakan card dengan shadow dan spacing
- ✅ **Smooth animations**: Hover effects, fade-in, slide-in (subtle)
- ✅ **Icon illustrations**: Tambah icon SVG untuk visual appeal
- ✅ **Readable**: Font size responsive, line height comfortable
- ✅ **Accessible**: Contrast ratio bagus, keyboard navigation

---

### Implementasi Responsive & Interaktif

#### 1. Visi & Misi - Redesign

**File**: `resources/views/public/profil/visi-misi.blade.php`

**CSS yang perlu ditambahkan** (bisa di file atau inline):

```css
/* Fade-in animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Card hover effect */
.profile-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.profile-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Misi list animation */
.misi-item {
    position: relative;
    padding-left: 2.5rem;
    transition: all 0.3s ease;
}

.misi-item:hover {
    transform: translateX(8px);
    color: #2563eb;
}

.misi-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive typography */
@media (max-width: 640px) {
    .hero-title {
        font-size: 2rem !important;
    }
    
    .section-title {
        font-size: 1.75rem !important;
    }
}
```

**Update HTML Structure**:

```blade
@extends('public.layouts.app')

@section('title', 'Visi & Misi - Desa Warurejo')

@section('content')

{{-- Hero Section - RESPONSIVE --}}
<section class="relative bg-gradient-to-r from-primary-600 via-primary-700 to-primary-800 text-white py-16 md:py-24 overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute transform rotate-45 -left-10 top-10 w-40 h-40 border-2 border-white rounded-lg"></div>
        <div class="absolute transform -rotate-45 right-10 bottom-10 w-32 h-32 border-2 border-white rounded-lg"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center fade-in-up">
            {{-- Breadcrumb --}}
            <nav class="text-sm mb-6">
                <ol class="flex items-center justify-center space-x-2 text-primary-100">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><span>/</span></li>
                    <li><a href="#" class="hover:text-white transition">Profil</a></li>
                    <li><span>/</span></li>
                    <li class="text-white font-semibold">Visi & Misi</li>
                </ol>
            </nav>
            
            {{-- Title --}}
            <h1 class="hero-title text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Visi & Misi
            </h1>
            <p class="text-lg md:text-xl text-primary-100 max-w-2xl mx-auto">
                Visi dan Misi Desa {{ $profil->nama_desa }} dalam Mewujudkan Desa yang Maju dan Sejahtera
            </p>
            
            {{-- Decorative Line --}}
            <div class="flex items-center justify-center mt-8">
                <div class="h-1 w-20 bg-amber-400 rounded-full"></div>
                <div class="h-2 w-2 bg-amber-400 rounded-full mx-2"></div>
                <div class="h-1 w-20 bg-amber-400 rounded-full"></div>
            </div>
        </div>
    </div>
</section>

{{-- Content Section - RESPONSIVE & INTERAKTIF --}}
<section class="py-12 md:py-16 lg:py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto space-y-12 md:space-y-16">
            
            {{-- ==================
                 VISI SECTION
            =================== --}}
            <div class="fade-in-up">
                {{-- Card VISI --}}
                <div class="profile-card bg-white rounded-2xl shadow-lg overflow-hidden">
                    {{-- Header dengan Icon --}}
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 md:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="section-title text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">
                                    VISI
                                </h2>
                                <p class="text-blue-100 text-sm md:text-base">Pandangan Masa Depan Desa</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="p-6 md:p-8 lg:p-10">
                        @if($profil->visi)
                            <div class="prose prose-sm md:prose-base lg:prose-lg max-w-none">
                                <p class="text-gray-700 text-base md:text-lg lg:text-xl leading-relaxed italic text-center md:text-left border-l-4 border-blue-600 pl-6 py-4 bg-blue-50 rounded-r-lg">
                                    "{{ $profil->visi }}"
                                </p>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500">Visi belum diisi oleh admin</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ==================
                 MISI SECTION
            =================== --}}
            <div class="fade-in-up" style="animation-delay: 0.2s">
                {{-- Card MISI --}}
                <div class="profile-card bg-white rounded-2xl shadow-lg overflow-hidden">
                    {{-- Header dengan Icon --}}
                    <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 md:p-8">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="section-title text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">
                                    MISI
                                </h2>
                                <p class="text-green-100 text-sm md:text-base">Langkah Strategis Pencapaian</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="p-6 md:p-8 lg:p-10">
                        @if($profil->misi_array && count($profil->misi_array) > 0)
                            <div class="space-y-4 md:space-y-5">
                                @foreach($profil->misi_array as $index => $misi)
                                    <div class="misi-item group">
                                        {{-- Number Badge --}}
                                        <div class="absolute left-0 top-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                                                <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                        
                                        {{-- Content --}}
                                        <div class="bg-gray-50 group-hover:bg-green-50 rounded-lg p-4 md:p-5 transition-colors">
                                            <p class="text-gray-700 text-sm md:text-base lg:text-lg leading-relaxed">
                                                {{ $misi }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500">Misi belum diisi oleh admin</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ==================
                 INFO BOX
            =================== --}}
            <div class="fade-in-up" style="animation-delay: 0.4s">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 p-6 md:p-8 rounded-lg shadow-md">
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-amber-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-lg md:text-xl mb-2">Catatan Penting</h3>
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                                Visi dan Misi ini menjadi pedoman bagi seluruh aparat pemerintah desa dan masyarakat dalam 
                                melaksanakan pembangunan desa untuk mewujudkan {{ $profil->nama_desa }} yang maju, sejahtera, 
                                dan mandiri.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
```

**Penjelasan Fitur Interaktif**:
1. ✅ **Fade-in animation** saat scroll (subtle)
2. ✅ **Card hover effect** - terangkat sedikit saat di-hover
3. ✅ **Misi items** - slide ke kanan saat hover
4. ✅ **Icon illustrations** - visual menarik tapi profesional
5. ✅ **Gradient backgrounds** - modern tapi tidak norak
6. ✅ **Responsive** - sempurna dari mobile sampai desktop

---

#### 2. Sejarah & Struktur Organisasi

Implementasinya **sama persis** dengan Visi & Misi di atas:
- Gunakan **card-based layout**
- Tambah **hover effects**
- Responsif dengan **breakpoints** (sm, md, lg)
- Icon SVG untuk visual appeal
- Gradient headers untuk section

**Key Points**:
- **Sejarah**: Gunakan timeline layout (mobile = vertical, desktop = horizontal)
- **Struktur**: Gambar struktur organisasi harus auto-resize, bisa di-zoom (modal lightbox)

---

## 🔴 MASALAH 4: Informasi (Berita, Potensi, dll) - Kurang Responsive & Interaktif

### Target:
- Halaman Berita Index & Detail
- Halaman Potensi Index & Detail
- Halaman Galeri

### Improvements:

1. **Grid Layout Responsive**:
   - Mobile: 1 kolom
   - Tablet: 2 kolom
   - Desktop: 3 kolom

2. **Card Hover Effects**:
   - Lift up sedikit (`translateY(-8px)`)
   - Shadow lebih besar
   - Gambar sedikit zoom (`scale(1.05)`)

3. **Lazy Loading**:
   - Semua gambar pakai `loading="lazy"`

4. **Skeleton Loading** (optional):
   - Tampilkan placeholder saat loading

**Contoh CSS untuk Card Interaktif**:

```css
.info-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.info-card img {
    transition: transform 0.5s ease;
}

.info-card:hover img {
    transform: scale(1.05);
}

/* Loading skeleton */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
```

---

## 🔴 MASALAH 5: Publikasi (APBDes, dll) - Kurang Responsive & Interaktif

### Improvements:

1. **Filter Kategori** - Sticky di mobile
2. **Card dengan Icon** - Sesuai jenis dokumen (PDF, Excel, dll)
3. **Download Button** - Jelas dan menarik
4. **Preview Modal** - Preview dokumen sebelum download (jika PDF)
5. **Stats** - Jumlah download, tanggal publikasi

**Contoh Button Download yang Menarik**:

```blade
<a href="{{ route('publikasi.download', $publikasi->id) }}" 
   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
          hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg 
          shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
    </svg>
    Download Dokumen
    <span class="ml-2 text-xs bg-white bg-opacity-20 px-2 py-1 rounded">
        {{ $publikasi->jumlah_download }} kali
    </span>
</a>
```

---

## 📝 Checklist Implementasi

### ✅ FASE 1: Backend & Database (Day 1-2)
- [ ] Migrate database - tambah field sambutan
- [ ] Update Model ProfilDesa
- [ ] Update ProfilDesaController (upload foto, save text)
- [ ] Update ProfilDesaRequest (validation)
- [ ] Update form admin (edit profil desa)
- [ ] Fix HomeController (counter akurat)

### ✅ FASE 2: Frontend Responsive (Day 3-4)
- [ ] Update home.blade.php (sambutan dynamic, counter fix)
- [ ] Redesign visi-misi.blade.php (responsive + interaktif)
- [ ] Redesign sejarah.blade.php (responsive + interaktif)
- [ ] Redesign struktur-organisasi.blade.php (responsive + interaktif)

### ✅ FASE 3: Informasi & Publikasi (Day 5-6)
- [ ] Update berita index & show (card hover, responsive)
- [ ] Update potensi index & show (card hover, responsive)
- [ ] Update galeri index (masonry layout, lightbox)
- [ ] Update publikasi index & show (download button, preview)

### ✅ FASE 4: Testing & Polish (Day 7)
- [ ] Test responsive di berbagai device (mobile, tablet, desktop)
- [ ] Test semua animasi smooth (tidak laggy)
- [ ] Test CRUD admin (upload foto, edit text)
- [ ] Test counter accuracy (sesuai dengan data asli)
- [ ] Performance optimization (lazy loading, caching)
- [ ] Browser compatibility (Chrome, Firefox, Safari, Edge)

---

## 🚀 Cara Mulai Implementasi

### Step 1: Clone & Setup
```bash
cd c:\xampp\htdocs\WebDesaWarurejo
git checkout pembuatan-fitur-week-3
```

### Step 2: Migrate Database
```bash
php artisan migrate
```

### Step 3: Update Files
Ikuti panduan di atas satu per satu, mulai dari:
1. ✅ Database & Model
2. ✅ Controller & Request
3. ✅ View Admin (form)
4. ✅ View Public (homepage, profil, dll)

### Step 4: Testing
```bash
php artisan serve
```
Buka browser, test semua fitur.

---

## 💡 Tips Implementasi

### Untuk Developer:
1. **Commit kecil-kecil** - Jangan sekaligus, commit per fitur
2. **Test di mobile** - Gunakan Chrome DevTools (F12 → Mobile View)
3. **Cache clear** - Jangan lupa clear cache setelah update view
4. **Backup database** - Sebelum migrate, backup dulu database

### Untuk Admin/User:
1. **Upload foto berkualitas** - Minimal 800x800px untuk sambutan
2. **Tulis sambutan singkat** - 3-5 paragraf sudah cukup
3. **Update berkala** - Jangan lupa update berita, potensi, galeri secara rutin

---

## 📞 Kontak & Support

Jika ada kendala implementasi:
- 📧 Email: [fajar.aprilian26@gmail.com]
- 💬 WhatsApp: [+6287838334950]
- 🔧 GitHub Issues: [buat issue di repo]

---

## 📚 Referensi

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/)
- [MDN Web Docs - Responsive Design](https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Responsive_Design)
- [Web.dev - Performance](https://web.dev/performance/)

---

**Dibuat oleh**: Kelompok 24  
**Tanggal**: 24 November 2025  
**Status**: 🔴 Dokumentasi - Siap untuk Implementasi  
**Estimasi**: 7 hari kerja (full implementation)

---

## 📌 Catatan Penting

> ⚠️ **PERHATIAN**:
> - Semua perubahan harus di-test di **mobile terlebih dahulu** (mobile-first)
> - Animasi harus **subtle** (tidak berlebihan untuk user awam)
> - Data counter **HARUS akurat** dengan data sebenarnya
> - Admin **HARUS bisa edit** sambutan tanpa coding
> - Backup database sebelum migrate!

---

**🎯 Goal Akhir**:
Website yang responsive, interaktif, akurat, dan mudah dikelola admin. User awam bisa dengan nyaman akses dari HP, admin bisa dengan mudah update konten tanpa programmer.

**✨ Let's build it!**
