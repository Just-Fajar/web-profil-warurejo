# 📄 Fitur Publikasi Dokumen Desa

## Deskripsi
Halaman publikasi dokumen desa yang memungkinkan masyarakat untuk mengakses dokumen-dokumen penting desa seperti APBDes, RPJMDes, dan RKPDes secara online.

## Fitur Utama

### 1. **Dropdown Kategori Publikasi**
- Pilihan kategori: APBDes, RPJMDes, RKPDes
- Otomatis filter dokumen berdasarkan kategori yang dipilih
- Default kategori: APBDes

### 2. **Filter Tahun**
- Tombol/tags tahun dinamis berdasarkan data yang tersedia
- Klik tahun untuk filter dokumen
- Tombol "Semua" untuk menampilkan semua tahun

### 3. **Daftar Dokumen**
Setiap dokumen menampilkan:
- ✅ Judul dokumen
- ✅ Tanggal publikasi
- ✅ Badge kategori dan tahun
- ✅ Preview thumbnail/icon dokumen
- ✅ Jumlah unduhan
- ✅ Deskripsi (jika ada)
- ✅ Tombol "Lihat Detail" dan "Unduh"

### 4. **Sidebar Publikasi Lainnya**
- Menampilkan 5 dokumen terbaru dari kategori lain
- Format: Icon + Judul + Kategori + Tahun
- Klik untuk langsung ke halaman detail dokumen

### 5. **Halaman Detail Dokumen**
- Preview PDF dalam iframe
- Informasi lengkap dokumen
- Tombol download
- Dokumen terkait (kategori sama)
- Counter unduhan otomatis

## Struktur Database

### Tabel: `publikasis`
```sql
- id (bigint, primary key)
- judul (string)
- kategori (enum: APBDes, RPJMDes, RKPDes)
- tahun (year)
- deskripsi (text, nullable)
- file_dokumen (string) - path ke file PDF
- thumbnail (string, nullable)
- tanggal_publikasi (date)
- status (enum: draft, published)
- jumlah_download (integer, default: 0)
- timestamps
```

## Routes

```php
// Public Routes
GET  /publikasi                    → Halaman daftar publikasi
GET  /publikasi/{id}               → Halaman detail dokumen
GET  /publikasi/{id}/download      → Download dokumen

// Query Parameters
?kategori=APBDes                   → Filter by kategori
?tahun=2025                        → Filter by tahun
```

## Cara Menggunakan

### 1. Akses Halaman Publikasi
Dari navbar → **Publikasi** → Pilih kategori (APBDes/RPJMDes/RKPDes)

### 2. Filter Dokumen
- Pilih kategori dari dropdown
- Klik tahun untuk filter berdasarkan tahun tertentu
- Klik "Semua" untuk menampilkan semua tahun

### 3. Lihat Detail Dokumen
- Klik tombol "Lihat Detail" pada dokumen
- Preview PDF akan ditampilkan
- Klik "Unduh" untuk download

### 4. Download Dokumen
- Counter download otomatis bertambah
- File PDF akan terdownload

## Upload Dokumen Baru (Admin)

### 1. Persiapkan File
- Format: PDF
- Simpan di folder: `storage/app/public/publikasi/`
- Nama file contoh: `apbdes-2025.pdf`

### 2. Insert Data ke Database
```php
use App\Models\Publikasi;
use Carbon\Carbon;

Publikasi::create([
    'judul' => 'APBDes Tahun 2025',
    'kategori' => 'APBDes', // APBDes, RPJMDes, atau RKPDes
    'tahun' => 2025,
    'deskripsi' => 'Deskripsi dokumen...',
    'file_dokumen' => 'publikasi/apbdes-2025.pdf',
    'thumbnail' => null, // optional
    'tanggal_publikasi' => Carbon::now(),
    'status' => 'published',
]);
```

### 3. Atau via Seeder
Edit file: `database/seeders/PublikasiSeeder.php`
```bash
php artisan db:seed --class=PublikasiSeeder
```

## Struktur File

```
app/
├── Http/Controllers/
│   └── PublikasiController.php          # Controller publikasi
├── Models/
│   └── Publikasi.php                    # Model publikasi

resources/views/public/publikasi/
├── index.blade.php                      # Halaman daftar
└── show.blade.php                       # Halaman detail

database/
├── migrations/
│   └── 2025_11_19_091317_create_publikasis_table.php
└── seeders/
    └── PublikasiSeeder.php              # Data contoh

storage/app/public/
└── publikasi/                           # Folder file PDF
    ├── apbdes-2025.pdf
    ├── rpjmdes-2024-2029.pdf
    └── rkpdes-2025.pdf
```

## Desain & UI

### Warna Branding
- **Primary (Hijau)**: #059669 (bg-primary-600)
- **Background**: Putih untuk area dokumen
- **Accent**: Hijau untuk tombol, tags, badge

### Responsif
- ✅ Desktop: Sidebar di kanan (3/4 + 1/4 layout)
- ✅ Tablet: Stack vertical
- ✅ Mobile: Full width, sidebar di bawah

### Components
- Badge kategori (warna hijau)
- Badge tahun (abu-abu)
- Card dokumen dengan hover effect
- Sticky sidebar
- Preview PDF iframe
- Download counter

## Fitur Tambahan

### 1. Counter Download
Setiap kali dokumen didownload, counter otomatis bertambah:
```php
$publikasi->incrementDownload();
```

### 2. Scopes untuk Query
```php
// Published only
Publikasi::published()->get();

// By kategori
Publikasi::byKategori('APBDes')->get();

// By tahun
Publikasi::byTahun(2025)->get();

// Latest first
Publikasi::latest()->get();
```

### 3. Attributes
```php
$publikasi->file_url        // URL file PDF
$publikasi->thumbnail_url   // URL thumbnail atau default
```

## Testing

### 1. Test Halaman Index
```
http://localhost/WebDesaWarurejo/public/publikasi
http://localhost/WebDesaWarurejo/public/publikasi?kategori=APBDes
http://localhost/WebDesaWarurejo/public/publikasi?kategori=RPJMDes&tahun=2024
```

### 2. Test Halaman Detail
```
http://localhost/WebDesaWarurejo/public/publikasi/1
```

### 3. Test Download
```
http://localhost/WebDesaWarurejo/public/publikasi/1/download
```

## Troubleshooting

### PDF Tidak Muncul di Preview
1. Pastikan file ada di `storage/app/public/publikasi/`
2. Jalankan: `php artisan storage:link`
3. Check permissions folder storage

### Filter Tidak Bekerja
1. Check query string di URL
2. Pastikan data tahun ada di database
3. Clear cache: `php artisan config:clear`

### Download Error 404
1. Pastikan path file_dokumen benar di database
2. Check file exists: `storage/app/public/{file_dokumen}`
3. Check route: `php artisan route:list | grep publikasi`

## Future Enhancements

### Admin Panel untuk Publikasi
- [ ] CRUD publikasi dari admin dashboard
- [ ] Upload file PDF langsung
- [ ] Generate thumbnail otomatis
- [ ] Bulk upload
- [ ] Analytics download per dokumen

### Public Features
- [ ] Search dokumen
- [ ] Share ke social media
- [ ] Print friendly version
- [ ] Email notification dokumen baru
- [ ] RSS feed publikasi

## Browser Support
- ✅ Chrome/Edge (Desktop & Mobile)
- ✅ Firefox (Desktop & Mobile)
- ✅ Safari (Desktop & Mobile)
- ✅ Opera

## Catatan Penting

1. **File Size**: Pastikan PDF tidak terlalu besar (max 10MB recommended)
2. **Naming Convention**: Gunakan nama file yang deskriptif dan lowercase
3. **Security**: File PDF harus di folder `storage/app/public` (tidak bisa diakses langsung)
4. **Backup**: Backup folder publikasi secara berkala

## Credits
Developed by: Tim Developer Desa Warurejo
Date: November 2025
Version: 1.0.0
