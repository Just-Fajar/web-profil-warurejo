# Website Profil Desa Warurejo

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind-4.1-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Alpine.js-3.15-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-success?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/Tests-Passed-brightgreen?style=flat-square" alt="Tests">
  <img src="https://img.shields.io/badge/Security-Hardened-blue?style=flat-square" alt="Security">
  <img src="https://img.shields.io/badge/API-REST%20v1-orange?style=flat-square" alt="API">
</p>

> Website profil desa modern dengan arsitektur enterprise-level, dilengkapi manajemen konten, galeri kegiatan, publikasi dokumen transparansi, dan sistem informasi desa terintegrasi.

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Panduan Instalasi](#panduan-instalasi)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Panduan Pengembangan](#panduan-pengembangan)
- [Pengujian](#pengujian)
- [Dokumentasi API](#dokumentasi-api)
- [Keamanan](#keamanan)
- [Optimasi Performa](#optimasi-performa)
- [Panduan Deployment](#panduan-deployment)
- [Lisensi](#lisensi)

---

## Tentang Proyek

Website Profil Desa Warurejo adalah aplikasi web yang dirancang untuk mengelola dan mempublikasikan informasi desa secara digital. Dibangun dengan standar enterprise-level, aplikasi ini menyediakan dashboard admin untuk manajemen konten serta antarmuka publik yang responsif, cepat, dan teroptimasi untuk mesin pencari (SEO).

### Sorotan Proyek

- **Arsitektur Berlapis:** Menggunakan kombinasi Repository Pattern dan Service Layer Pattern untuk pemisahan tanggung jawab kode yang rapi dan mudah dirawat.
- **Keamanan Teruji:** Dilengkapi HTML Sanitizer kustom untuk mitigasi XSS, Rate Limiting pada autentikasi, proteksi CSRF, serta pelacakan pengunjung ramah privasi (GDPR compliant).
- **Performa Tinggi:** Sistem caching bertingkat (multi-layer caching) dengan invalidasi otomatis dan optimasi aset media otomatis.
- **RESTful API Siap Pakai:** Menyediakan endpoint terstruktur berbasis Laravel Sanctum dan dokumentasi Swagger/OpenAPI untuk integrasi aplikasi pihak ketiga.
- **Dokumentasi Komprehensif:** Dilengkapi panduan teknis mendalam mulai dari setup, pengujian, pemantauan, hingga deployment server.

---

## Fitur Utama

### 1. Halaman Publik

#### Beranda (Homepage)
- Banner visual desa dengan navigasi terstruktur.
- Ringkasan statistik desa real-time (jumlah artikel, potensi, galeri, pengunjung).
- Tampilan artikel berita terkini dengan lazy loading gambar.
- Sorotan potensi unggulan desa dan galeri dokumentasi kegiatan.
- Floating Action Button (FAB) WhatsApp untuk akses kontak cepat.

#### Profil Desa
- Informasi visi dan misi desa.
- Catatan sejarah dan perkembangan desa.
- Bagan struktur organisasi kepengurusan desa.
- Informasi demografis dan peta interaktif wilayah desa.

#### Berita dan Informasi
- Daftar berita dengan pagination dan pencarian instan.
- Autocomplete search real-time.
- Penyaringan berdasarkan kategori, rentang tanggal, dan popularitas.
- Penghitung jumlah pembaca (view counter) dan artikel terkait.
- Optimasi meta tag Open Graph dan Twitter Card untuk pembagian tautan ke media sosial.

#### Potensi Desa
- Showcase potensi dalam 7 kategori (Pertanian, Pariwisata, UMKM, Peternakan, Perikanan, Kerajinan, dan Lainnya).
- Informasi lokasi, deskripsi lengkap, dan kontak WhatsApp langsung ke penanggung jawab potensi.
- Filter berdasarkan kategori dan pengurutan prioritas.

#### Galeri Dokumentasi
- Kategori dokumentasi: Kegiatan, Infrastruktur, Budaya, dan Umum.
- Dukungan multi-foto per album kegiatan.
- Tampilan interaktif dengan lightbox viewer dan lazy loading.

#### Publikasi dan Transparansi
- Akses dan unduhan dokumen publik desa (APBDes, RPJMDes, RKPDes).
- Preview dokumen PDF langsung di peramban.
- Pelacak jumlah unduhan (download counter).

---

### 2. Panel Admin

#### Dashboard Analitik
- Ringkasan metrik statistik konten dan aktivitas sistem.
- Grafik visual pengunjung harian dan pageviews (berbasis Chart.js).
- Grafik tren pertumbuhan konten tahunan.

#### Manajemen Konten
- **Berita:** Editor teks kaya (TinyMCE), pemrosesan gambar otomatis, penanganan status draft/published, serta fitur bulk delete.
- **Potensi Desa:** Pengelolaan data potensi desa, penetapan urutan tampilan, dan integrasi nomor kontak.
- **Galeri:** Multi-upload berkas gambar, kompresi otomatis, dan pengaturan visibilitas album.
- **Publikasi Dokumen:** Upload dan pengelolaan dokumen regulasi serta transparansi anggaran.
- **Struktur Organisasi:** Pengelolaan bagan hierarki kepengurusan desa beserta jabatan dan foto.

#### Akun dan Keamanan Admin
- Guard autentikasi terpisah khusus admin.
- Proteksi brute force melalui pembatasan percobaan login (rate limiting).
- Manajemen profil admin: pembaruan data diri, pemotongan foto profil otomatis (400x400), dan pembaruan kata sandi.

---

## Tech Stack

### Backend
- **Framework:** Laravel 12.x
- **Bahasa Pemrograman:** PHP 8.2+
- **Basis Data:** MySQL 8.0+ / SQLite (pengembangan & testing)
- **Autentikasi:** Laravel Sanctum (API) & Session Guard (Web Admin)
- **Cache Engine:** Redis / Database / File

### Frontend
- **CSS Framework:** Tailwind CSS 4.1
- **JavaScript Framework:** Alpine.js 3.15
- **Asset Bundler:** Vite 7.0
- **Editor Teks:** TinyMCE
- **Visualisasi Data:** Chart.js

### Dependensi Utama
- `darkaonline/l5-swagger`: Dokumentasi OpenAPI/Swagger
- `intervention/image`: Manipulasi dan kompresi gambar
- `mews/purifier`: Sanitasi HTML
- `spatie/laravel-sitemap`: Pembuatan sitemap XML otomatis

### Peralatan Pengembangan
- `phpunit/phpunit`: Kerangka kerja pengujian unit dan fitur
- `laravel/pint`: Pengecekan dan perapian standar kode
- `barryvdh/laravel-debugbar`: Toolbar debugging (khusus development)
- `laravel/pail`: Penampil log interaktif di terminal

---

## Arsitektur Sistem

Aplikasi ini mengadopsi pola **Controller -> Service -> Repository -> Model**, menjamin pemisahan tanggung jawab (*Separation of Concerns*) dan mempermudah pengujian otomatis.

```
[ Request Masuk ]
       |
       v
[ Middleware Layer ] (Rate Limiter, TrackVisitor, Admin Authenticate)
       |
       v
[ Controller Layer ] (Menerima input, validasi request, mengirim respons)
       |
       v
[ Service Layer ] (Logika bisnis, pemrosesan media, sanitasi HTML, cache)
       |
       v
[ Repository Layer ] (Abstraksi query basis data & relasi model)
       |
       v
[ Model & Database ] (Eloquent ORM & Relational DB)
```

### Struktur Direktori Utama

```
app/
├── Console/
│   └── Commands/
│       └── OptimizeImages.php       # Perintah optimasi & konversi WebP
├── Helpers/
│   └── SEOHelper.php                # Utilitas metadata & schema JSON-LD
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                   # Controller panel administrasi
│   │   ├── Api/                     # Controller RESTful API v1
│   │   └── Public/                  # Controller halaman publik
│   └── Middleware/
│       ├── AdminAuthenticate.php    # Proteksi rute admin
│       └── TrackVisitor.php         # Analitik pengunjung tanpa data pribadi
├── Models/                          # Model Eloquent
├── Providers/                       # Registrasi singleton service & repository
├── Repositories/                    # Lapisan akses data (Repository Pattern)
└── Services/                        # Lapisan logika bisnis (Service Pattern)
```

---

## Panduan Instalasi

### Persyaratan Sistem

- PHP >= 8.2 (dengan ekstensi: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, GD / Imagick)
- Composer >= 2.x
- Node.js >= 20.x dan npm
- MySQL >= 8.0 atau SQLite
- Git

### Langkah Pemasangan

1. **Clone repositori:**
   ```bash
   git clone https://github.com/Just-Fajar/web-profil-warurejo.git
   cd web-profil-warurejo
   ```

2. **Pasang dependensi PHP dan Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Siapkan berkas konfigurasi:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasikan koneksi basis data pada berkas `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=warurejo
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi basis data dan seeder:**
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symbolic link untuk direktori penyimpanan publik:**
   ```bash
   php artisan storage:link
   ```

7. **Kompilasi aset antarmuka:**
   ```bash
   npm run build
   ```

8. **Jalankan server pengembangan:**
   ```bash
   php artisan serve
   ```

Akses aplikasi melalui peramban di `http://localhost:8000`.

---

## Konfigurasi Environment

Contoh konfigurasi penting pada berkas `.env`:

```env
# Aplikasi
APP_NAME="Desa Warurejo"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# Basis Data
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warurejo
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Cache (Rekomendasi Redis untuk Produksi)
CACHE_STORE=file
CACHE_PROFIL_TTL=86400
CACHE_BERITA_TTL=3600
CACHE_POTENSI_TTL=21600
CACHE_GALERI_TTL=10800
CACHE_SEO_TTL=86400

# Session & Queue
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
```

---

## Panduan Pengembangan

### Menjalankan Lingkungan Pengembangan Terpadu

Gunakan perintah bawaan composer untuk menjalankan server HTTP, worker antrean, pemantau log, dan Vite secara bersamaan:

```bash
composer run dev
```

Atau jalankan layanan secara terpisah di terminal yang berbeda:

```bash
# Server Laravel
php artisan serve

# Vite HMR (Hot Module Replacement)
npm run dev

# Queue Listener
php artisan queue:listen

# Pemantau Log
php artisan pail
```

### Standar Format Kode

Format seluruh kode proyek menggunakan Laravel Pint:

```bash
# Format kode otomatis
./vendor/bin/pint

# Pengecekan tanpa modifikasi
./vendor/bin/pint --test
```

### Pembersihan dan Manajemen Cache

```bash
# Bersihkan seluruh cache aplikasi
php artisan optimize:clear

# Optimasi konfigurasi, rute, dan view untuk produksi
php artisan optimize
```

### Optimasi Aset Gambar

Gunakan artisan command untuk melakukan kompresi dan konversi gambar ke format WebP:

```bash
# Optimasi seluruh gambar
php artisan images:optimize

# Konversi dan buat versi WebP
php artisan images:optimize --webp
```

---

## Pengujian

Proyek ini dilengkapi pengujian otomatis mencakup Unit Test untuk Service Layer dan Feature Test untuk Endpoint HTTP dan Akses Admin.

### Menjalankan Test Suite

```bash
# Jalankan seluruh tes
php artisan test

# Jalankan pengujian secara paralel
php artisan test --parallel

# Jalankan suite tertentu
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Jalankan berkas tes spesifik
php artisan test tests/Feature/HomePageTest.php
```

---

## Dokumentasi API

Endpoint RESTful API v1 tersedia untuk integrasi aplikasi mobile atau layanan pihak ketiga.

### Base URL

- **Development:** `http://localhost:8000/api/v1`
- **Production:** `https://warurejo.desa.id/api/v1`

### Ringkasan Endpoint

#### Autentikasi
- `POST /api/v1/login` - Mendapatkan token autentikasi (Sanctum)
- `POST /api/v1/logout` - Mencabut token sesi aktif
- `POST /api/v1/logout-all` - Mencabut seluruh token akun
- `GET /api/v1/me` - Menampilkan profil pengguna terautentikasi
- `GET /api/v1/tokens` - Menampilkan daftar token aktif

#### Berita
- `GET /api/v1/berita` - Daftar berita (mendukung filter & pagination)
- `GET /api/v1/berita/latest` - Daftar berita terbaru
- `GET /api/v1/berita/popular` - Daftar berita terpopuler
- `GET /api/v1/berita/{slug}` - Detail artikel berdasarkan slug

#### Potensi Desa
- `GET /api/v1/potensi` - Daftar potensi desa
- `GET /api/v1/potensi/featured` - Daftar potensi unggulan
- `GET /api/v1/potensi/{slug}` - Detail potensi desa

#### Galeri
- `GET /api/v1/galeri` - Daftar album galeri kegiatan
- `GET /api/v1/galeri/latest` - Dokumentasi galeri terbaru
- `GET /api/v1/galeri/categories` - Daftar kategori galeri
- `GET /api/v1/galeri/{id}` - Detail album galeri beserta foto terkait

### Menghasilkan Dokumentasi Swagger

Dokumentasi OpenAPI interaktif dapat di-generate menggunakan perintah:

```bash
php artisan l5-swagger:generate
```

Akses dokumentasi antarmuka Swagger melalui browser pada:
`http://localhost:8000/api/documentation`

---

## Keamanan

Penerapan standar keamanan pada aplikasi:

1. **Rate Limiting:**
   - Pembatasan upaya login admin: maksimal 5 percobaan per menit.
   - Pembatasan pemanggilan API: 60 request per menit untuk endpoint publik.
2. **Sanitasi Konten (XSS Mitigation):**
   - Pembersihan input HTML dari teks editor melalui `HtmlSanitizerService`.
   - Penghapusan tag berisiko (`<script>`, `<iframe>`, `<object>`) dan pembersihan protokol tidak aman (`javascript:`, `data:`).
3. **Perlindungan CSRF:** Seluruh formulir web publik dan admin dilindungi token CSRF otomatis.
4. **Keamanan Basis Data:** Pencegahan SQL Injection menggunakan parameterized queries dari Eloquent ORM.
5. **Validasi Berkas:** Pembatasan tipe berkas (MIME-type check) dan ukuran maksimum 2MB untuk upload gambar dan dokumen PDF.
6. **Enforce HTTPS:** Pengalihan otomatis ke protokol HTTPS saat aplikasi berjalan di lingkungan produksi.

---

## Optimasi Performa

Penerapan teknik peningkatan kecepatan akses:

1. **Multi-layer Cache:** Menyimpan data yang jarang berubah pada cache (Profil Desa 24 jam, Berita 1 jam, Potensi 6 jam, Galeri 3 jam).
2. **Pencegahan N+1 Query:** Memanfaatkan eager loading (`with(...)`) pada repositori untuk meminimalkan beban kueri basis data.
3. **Database Indexing:** Penerapan composite index pada kolom-kolom penelusuran dan penyaringan data (`status`, `published_at`, `kategori`, `is_active`).
4. **Optimasi Aset Frontend:** Pemanfaatan Vite dengan minifikasi Terser dan pemisahan vendor chunks.

---

## Panduan Deployment

### Ringkasan Langkah Deployment VPS (Ubuntu / Nginx)

1. Clone repositori ke server produksi:
   ```bash
   git clone https://github.com/Just-Fajar/web-profil-warurejo.git /var/www/warurejo
   cd /var/www/warurejo
   ```

2. Pasang dependensi untuk mode produksi:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install && npm run build
   ```

3. Sesuaikan berkas konfigurasi `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan `APP_ENV=production` dan `APP_DEBUG=false`.

4. Jalankan migrasi basis data:
   ```bash
   php artisan migrate --force
   ```

5. Atur kepemilikan dan hak akses direktori:
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache
   sudo chmod -R 775 storage bootstrap/cache
   ```

6. Cache seluruh konfigurasi:
   ```bash
   php artisan optimize
   ```

7. Konfigurasikan cron job untuk penjadwalan tugas Laravel:
   ```bash
   * * * * * cd /var/www/warurejo && php artisan schedule:run >> /dev/null 2>&1
   ```

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
Hak Cipta (c) 2025 Just Fajar.
