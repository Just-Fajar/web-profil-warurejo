# 🔄 Panduan Pemulihan Sistem Publikasi

## ✅ Status: SISTEM SUDAH DIPULIHKAN

Semua file yang diperlukan untuk sistem publikasi (public & admin) sudah berhasil dipulihkan dan siap digunakan.

---

## 📋 File yang Sudah Dipulihkan

### ✅ Views - Public (2 files)
```
resources/views/public/publikasi/
├── index.blade.php   ✅ DIPULIHKAN (file kosong → lengkap dengan filtering)
└── show.blade.php    ✅ SUDAH ADA (detail publikasi dengan PDF preview)
```

### ✅ Views - Admin (3 files)
```
resources/views/admin/publikasi/
├── index.blade.php   ✅ SUDAH ADA (listing dengan filter & bulk delete)
├── create.blade.php  ✅ SUDAH ADA (form upload PDF & thumbnail)
└── edit.blade.php    ✅ SUDAH ADA (form edit dengan preview)
```

### ✅ Controller - Public
```
app/Http/Controllers/PublikasiController.php
- index()    ✅ List publikasi by kategori dengan filter
- show()     ✅ Detail publikasi dengan PDF preview
- download() ✅ Download PDF dengan increment counter
```

### ✅ Controller - Admin
```
app/Http/Controllers/Admin/PublikasiController.php
- index()      ✅ Admin listing dengan search & filter
- create()     ✅ Show upload form
- store()      ✅ Save publikasi + file upload
- show()       ✅ Admin preview
- edit()       ✅ Show edit form
- update()     ✅ Update publikasi + replace file
- destroy()    ✅ Delete publikasi + cleanup files
- bulkDelete() ✅ Multiple delete via AJAX
```

### ✅ Model
```
app/Models/Publikasi.php
- Scopes: published(), byKategori(), byTahun(), latest()
- Attributes: file_url, thumbnail_url
- Methods: incrementDownload()
```

### ✅ Routes (11 routes)
```
PUBLIC:
- GET  /publikasi                    → List publikasi
- GET  /publikasi/{id}              → Detail publikasi
- GET  /publikasi/{id}/download     → Download PDF

ADMIN:
- GET    /admin/publikasi                   → Admin list
- GET    /admin/publikasi/create           → Upload form
- POST   /admin/publikasi                  → Store publikasi
- GET    /admin/publikasi/{id}/edit        → Edit form
- PUT    /admin/publikasi/{id}             → Update publikasi
- DELETE /admin/publikasi/{id}             → Delete publikasi
- GET    /admin/publikasi/{id}             → Admin preview
- POST   /admin/publikasi/bulk-delete      → Bulk delete
```

---

## 🎯 Cara Mengakses Sistem

### 1️⃣ Halaman Public (Pengunjung)

**URL:** `http://localhost/WebDesaWarurejo/publikasi`

**Fitur yang tersedia:**
- ✅ Dropdown kategori (APBDes, RPJMDes, RKPDes)
- ✅ Filter tahun dengan tag button
- ✅ Grid view dokumen dengan thumbnail
- ✅ Button "Lihat Detail" (preview PDF)
- ✅ Button "Unduh" (download PDF)
- ✅ Sidebar publikasi lainnya
- ✅ Info box
- ✅ Pagination
- ✅ Counter download

**Cara Pakai:**
1. Buka URL publikasi di browser
2. Pilih kategori dari dropdown (APBDes/RPJMDes/RKPDes)
3. (Optional) Filter tahun dengan klik tag tahun
4. Klik "Lihat Detail" untuk preview PDF
5. Klik "Unduh" untuk download file

### 2️⃣ Halaman Admin

**URL:** `http://localhost/WebDesaWarurejo/admin/publikasi`

**Login Admin:**
```
Email: admin@warurejo.desa.id
Password: password (default)
```

**Fitur yang tersedia:**
- ✅ Search by judul
- ✅ Filter kategori dropdown
- ✅ Filter tahun dropdown
- ✅ Filter status (Published/Draft)
- ✅ Bulk delete dengan checkbox
- ✅ Actions: View, Edit, Delete
- ✅ Upload publikasi baru
- ✅ Edit publikasi existing
- ✅ Status badges
- ✅ Download counter display

**Cara Upload Publikasi Baru:**
1. Login ke admin panel
2. Click menu "Publikasi" di sidebar ATAU
3. Click "Upload Publikasi" di dashboard quick actions
4. Isi form:
   - Judul: (required) contoh: "APBDes Warurejo 2025"
   - Kategori: (required) pilih APBDes/RPJMDes/RKPDes
   - Tahun: (required) contoh: 2025
   - Deskripsi: (optional) deskripsi singkat
   - File PDF: (required) upload file PDF max 10MB
   - Thumbnail: (optional) upload gambar preview max 2MB
   - Tanggal Publikasi: (required) pilih tanggal
   - Status: (required) Published/Draft
5. Click "Simpan Publikasi"
6. ✅ File akan tersimpan di `storage/app/public/publikasi/`

**Cara Edit Publikasi:**
1. Buka halaman admin publikasi
2. Click ikon edit (yellow) di row yang ingin diedit
3. Update field yang diperlukan
4. (Optional) Upload file/thumbnail baru untuk replace
5. Click "Perbarui Publikasi"

**Cara Hapus Publikasi:**
- **Single:** Click ikon trash (red) → konfirmasi OK
- **Bulk:** Centang checkbox → Click "Hapus Terpilih" → konfirmasi OK

---

## 🗂️ Struktur Database

### Table: `publikasis`
```sql
CREATE TABLE publikasis (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    kategori ENUM('APBDes', 'RPJMDes', 'RKPDes') NOT NULL,
    tahun INT NOT NULL,
    deskripsi TEXT NULL,
    file_dokumen VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255) NULL,
    tanggal_publikasi DATE NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    jumlah_download INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Sample Data (8 records)
Database sudah di-seed dengan 8 sample publikasi:
- 3 APBDes (2023, 2024, 2025)
- 3 RPJMDes (2020-2026, 2021-2026, 2022-2027)
- 2 RKPDes (2024, 2025)

---

## 📂 Lokasi File Storage

### Upload Files Location
```
storage/app/public/publikasi/           → PDF files
storage/app/public/publikasi/thumbnails/ → Thumbnail images
```

### Public Access via Symlink
```
public/storage → symlink to storage/app/public
```

**Cek Symlink:**
```bash
php artisan storage:link
```

---

## 🎨 Design Specifications

### Public Page
- **Layout:** Main content (75%) + Sidebar (25%)
- **Filter:** Dropdown kategori + Tag buttons tahun
- **Cards:** Thumbnail (left) + Content (right)
- **Colors:**
  - APBDes: Blue badges
  - RPJMDes: Green badges
  - RKPDes: Purple badges
  - Primary button: bg-primary-600
  - Download button: bg-green-600

### Admin Page
- **Layout:** Full width table
- **Filters:** 4 filters (search, kategori, tahun, status) + reset button
- **Table:** 8 columns dengan sticky header
- **Actions:** View (blue), Edit (yellow), Delete (red)
- **Bulk Actions:** Checkbox select all + bulk delete button
- **Forms:** 2-column layout (main + sidebar)

---

## ✅ Checklist Verifikasi

### Public System
- [x] Route `/publikasi` bisa diakses
- [x] Dropdown kategori berfungsi
- [x] Filter tahun berfungsi
- [x] Cards publikasi tampil dengan benar
- [x] Button "Lihat Detail" redirect ke show page
- [x] Button "Unduh" download PDF
- [x] Sidebar publikasi lainnya tampil
- [x] Pagination berfungsi
- [x] Counter download increment

### Admin System
- [x] Route `/admin/publikasi` bisa diakses (perlu login)
- [x] Menu "Publikasi" di sidebar tampil
- [x] Dashboard quick action "Upload Publikasi" tampil
- [x] Search by judul berfungsi
- [x] Filter kategori, tahun, status berfungsi
- [x] Form upload berfungsi (PDF + thumbnail)
- [x] Form edit berfungsi (preview files)
- [x] Delete single berfungsi (cleanup files)
- [x] Bulk delete berfungsi (cleanup multiple files)
- [x] Validation errors tampil dengan benar
- [x] Success messages tampil

### Integration
- [x] 11 routes terdaftar di route:list
- [x] Controller public ada dan lengkap
- [x] Controller admin ada dan lengkap
- [x] Model Publikasi ada dengan scopes
- [x] Storage symlink aktif
- [x] Dashboard statistics tampil total publikasi
- [x] Navbar public ada link ke publikasi

---

## 🚀 Testing Commands

### Check Routes
```bash
php artisan route:list --path=publikasi
```

### Check Storage Link
```bash
php artisan storage:link
```

### Check Database
```bash
php artisan tinker
Publikasi::count()  # Should return 8 (seeded data)
Publikasi::published()->count()  # Should return 8
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🔧 Troubleshooting

### Problem: File PDF tidak bisa didownload
**Solution:**
```bash
# Pastikan storage link aktif
php artisan storage:link

# Cek permission folder storage
chmod -R 775 storage/
```

### Problem: Gambar thumbnail tidak muncul
**Solution:**
1. Cek file ada di `storage/app/public/publikasi/thumbnails/`
2. Pastikan symlink aktif: `public/storage` → `storage/app/public`
3. Cek permission folder public: `chmod -R 755 public/storage`

### Problem: Form upload error "file too large"
**Solution:**
Edit `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 12M
```
Restart Apache/Nginx

### Problem: Publikasi tidak muncul di public
**Solution:**
Pastikan status publikasi = "published" (bukan "draft")

### Problem: Error 404 saat akses publikasi
**Solution:**
```bash
# Clear cache
php artisan route:clear
php artisan config:clear

# Restart server
php artisan serve
```

---

## 📌 Quick Links

### Public URLs
- Publikasi List: `http://localhost/WebDesaWarurejo/publikasi`
- APBDes: `http://localhost/WebDesaWarurejo/publikasi?kategori=APBDes`
- RPJMDes: `http://localhost/WebDesaWarurejo/publikasi?kategori=RPJMDes`
- RKPDes: `http://localhost/WebDesaWarurejo/publikasi?kategori=RKPDes`

### Admin URLs
- Admin Dashboard: `http://localhost/WebDesaWarurejo/admin/dashboard`
- Publikasi List: `http://localhost/WebDesaWarurejo/admin/publikasi`
- Upload Form: `http://localhost/WebDesaWarurejo/admin/publikasi/create`

---

## 🎉 Kesimpulan

**SEMUA SISTEM PUBLIKASI SUDAH DIPULIHKAN DAN SIAP DIGUNAKAN!**

✅ File views public sudah dipulihkan (index.blade.php yang kosong)
✅ File views admin sudah lengkap (3 files)
✅ Controller public & admin sudah lengkap
✅ Model Publikasi sudah ada dengan semua scopes
✅ Routes sudah terdaftar (11 routes)
✅ Storage symlink sudah aktif
✅ Database migration & seeder sudah lengkap

**Anda sekarang bisa:**
1. Akses halaman public di `/publikasi` ✅
2. Login admin dan kelola publikasi di `/admin/publikasi` ✅
3. Upload dokumen PDF baru ✅
4. Edit publikasi existing ✅
5. Delete publikasi (single & bulk) ✅
6. Filter & search publikasi ✅
7. Download PDF dengan counter ✅

**Sistem 100% READY FOR USE! 🚀**
