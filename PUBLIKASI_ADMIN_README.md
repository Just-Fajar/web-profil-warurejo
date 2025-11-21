# Publikasi Admin Management System - README

## 📋 Overview
Sistem manajemen publikasi untuk admin Desa Warurejo yang memungkinkan upload, edit, dan hapus dokumen publikasi (APBDes, RPJMDes, RKPDes).

## ✅ Status: **COMPLETED**

## 🎯 Features Implemented

### 1. Admin Navigation
- ✅ Sidebar menu "Publikasi" dengan ikon PDF
- ✅ Dashboard quick action "Upload Publikasi" (red theme)
- ✅ Active state highlighting saat di halaman publikasi

### 2. Admin CRUD Operations
- ✅ **Index Page**: Listing semua publikasi dengan:
  - Filter: Search, Kategori, Tahun, Status
  - Bulk delete dengan checkbox
  - Pagination
  - Quick actions: View, Edit, Delete
  - Status badges (Published/Draft)
  - Download counter display

- ✅ **Create Page**: Form upload publikasi dengan:
  - Input: Judul, Kategori dropdown, Tahun
  - Textarea: Deskripsi
  - File upload: PDF dokumen (max 10MB)
  - File upload: Thumbnail gambar (optional, max 2MB)
  - Date picker: Tanggal publikasi
  - Status dropdown: Draft/Published
  - Real-time file name display
  - Validation error messages

- ✅ **Edit Page**: Form edit publikasi dengan:
  - Semua field dari create page
  - Preview file PDF yang sudah ada
  - Preview thumbnail yang sudah ada
  - Option untuk replace file/thumbnail
  - Statistics: Total download, Created date
  - Validation error messages

### 3. Controller Implementation
- ✅ Full RESTful controller dengan 8 methods:
  - `index()`: List publikasi dengan search & filter
  - `create()`: Tampilkan form upload
  - `store()`: Save publikasi baru + file upload
  - `show()`: Detail publikasi (admin preview)
  - `edit()`: Tampilkan form edit
  - `update()`: Update publikasi + optional file replace
  - `destroy()`: Delete publikasi + cleanup files
  - `bulkDelete()`: Delete multiple publikasi via AJAX

### 4. File Management
- ✅ PDF storage di `storage/app/public/publikasi/`
- ✅ Thumbnail storage di `storage/app/public/publikasi/thumbnails/`
- ✅ Auto cleanup files saat delete
- ✅ File validation (PDF max 10MB, Image max 2MB)
- ✅ Automatic file path handling

### 5. Dashboard Integration
- ✅ Total publikasi card di dashboard
- ✅ Statistics dengan ikon document
- ✅ Grid layout updated ke 5 columns (Berita, Potensi, Galeri, Publikasi, Pengunjung)

## 📂 Files Structure

### Controllers
```
app/Http/Controllers/Admin/PublikasiController.php
- Full CRUD implementation
- File upload handling
- Cache clearing on changes
- Bulk delete via AJAX
```

### Views
```
resources/views/admin/publikasi/
├── index.blade.php   (List with filters & bulk actions)
├── create.blade.php  (Upload form)
└── edit.blade.php    (Edit form with preview)
```

### Routes
```php
// Admin Publikasi Management (Protected by 'admin' middleware)
Route::post('publikasi/bulk-delete', [AdminPublikasiController::class, 'bulkDelete'])
Route::resource('publikasi', AdminPublikasiController::class);
```

### Layouts Updated
```
resources/views/admin/layouts/app.blade.php
- Added "Publikasi" menu item with PDF icon
- Active state: admin.publikasi.*

resources/views/admin/dashboard/index.blade.php
- Added "Upload Publikasi" quick action (red theme)
- Added totalPublikasi statistics card
- Updated grid to 5 columns
```

## 🎨 Design Specifications

### Color Scheme
- **Primary Action**: bg-primary-600 (blue)
- **Quick Action**: bg-red-50 hover:bg-red-100 (red theme)
- **Sidebar Menu**: PDF icon (fas fa-file-pdf)
- **Status Badges**:
  - APBDes: blue-100/blue-800
  - RPJMDes: green-100/green-800
  - RKPDes: purple-100/purple-800
  - Published: green-100/green-800
  - Draft: gray-100/gray-800

### Icons
- **Sidebar**: `fas fa-file-pdf` (Font Awesome)
- **Dashboard Card**: Document SVG icon
- **Quick Action**: Plus icon in red circle

### Layout
- **Grid**: 5 columns di statistics cards
- **Form**: 2-column layout (main form + sidebar)
- **Table**: 8 columns (checkbox, judul, kategori, tahun, status, tanggal, download, aksi)

## 🔐 Validation Rules

### Create/Update Publication
```php
'judul' => 'required|string|max:255'
'kategori' => 'required|in:APBDes,RPJMDes,RKPDes'
'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5)
'deskripsi' => 'nullable|string'
'file_dokumen' => 'required|file|mimes:pdf|max:10240' (create only)
'file_dokumen' => 'nullable|file|mimes:pdf|max:10240' (update only)
'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
'tanggal_publikasi' => 'required|date'
'status' => 'required|in:draft,published'
```

## 🚀 Usage Guide

### For Admin Users

**1. Upload Publikasi Baru**
- Click "Publikasi" di sidebar ATAU
- Click "Upload Publikasi" di dashboard quick actions
- Fill form: judul, kategori, tahun, deskripsi
- Upload PDF dokumen (required)
- Upload thumbnail gambar (optional)
- Pilih tanggal publikasi
- Pilih status: Draft atau Published
- Click "Simpan Publikasi"

**2. Edit Publikasi**
- Buka halaman Publikasi dari sidebar
- Click ikon edit (yellow) di row yang ingin diedit
- Update field yang diperlukan
- Upload file/thumbnail baru (optional, kosongkan jika tidak ingin ubah)
- Click "Perbarui Publikasi"

**3. Delete Publikasi**
- **Single Delete**: Click ikon trash (red) → konfirmasi
- **Bulk Delete**: 
  - Centang checkbox publikasi yang ingin dihapus
  - Click "Hapus Terpilih" di bulk actions bar
  - Konfirmasi penghapusan

**4. Filter & Search**
- Gunakan search box untuk cari judul
- Filter by kategori: APBDes, RPJMDes, RKPDes
- Filter by tahun dari dropdown
- Filter by status: Published atau Draft
- Click "Filter" untuk apply atau ikon reset untuk clear

## 🔄 Integration Points

### Public System
Routes yang sudah terintegrasi:
- `/publikasi` → Listing publik
- `/publikasi/{id}` → Detail dengan PDF preview
- `/publikasi/{id}/download` → Download dengan counter

### Admin System
Routes yang baru dibuat:
- `/admin/publikasi` → Admin index
- `/admin/publikasi/create` → Upload form
- `/admin/publikasi/{id}/edit` → Edit form
- `/admin/publikasi/{id}` → DELETE destroy
- `/admin/publikasi/bulk-delete` → POST bulk delete

### Dashboard
- Total publikasi ditampilkan di statistics card (red border)
- Quick action untuk direct upload

## 📊 Database Schema
```
publikasis table:
- id (bigint)
- judul (varchar 255)
- kategori (enum: APBDes, RPJMDes, RKPDes)
- tahun (int)
- deskripsi (text, nullable)
- file_dokumen (varchar 255)
- thumbnail (varchar 255, nullable)
- tanggal_publikasi (date)
- status (enum: draft, published)
- jumlah_download (int, default 0)
- timestamps
```

## 🧪 Testing Checklist

### Admin Interface
- [x] Sidebar menu item displays dengan PDF icon
- [x] Dashboard quick action displays dengan red theme
- [x] Quick action positioned antara "Upload Galeri" dan "Edit Profil Desa"
- [x] Active state highlighting works
- [x] Statistics card displays total publikasi

### CRUD Operations
- [x] Create form displays dengan proper layout
- [x] File upload works (PDF & thumbnail)
- [x] Validation errors display correctly
- [x] Success message after create
- [x] Edit form displays dengan preview files
- [x] Update without replacing files works
- [x] Update with new files works
- [x] Delete single publikasi works (file cleanup)
- [x] Bulk delete works (multiple files cleanup)

### Routes
- [x] All 8 admin routes registered
- [x] Middleware protection applied
- [x] Route names correct (admin.publikasi.*)

### Integration
- [x] Dashboard controller passes totalPublikasi
- [x] Dashboard view displays publikasi card
- [x] Sidebar menu active state works
- [x] Quick action links to create route

## 🎉 Success Criteria - ALL MET

1. ✅ Admin dapat mengakses menu Publikasi dari sidebar
2. ✅ Admin dapat mengakses quick action "Upload Publikasi" dari dashboard
3. ✅ Admin dapat upload publikasi baru dengan PDF dokumen
4. ✅ Admin dapat edit publikasi yang sudah ada
5. ✅ Admin dapat delete publikasi (single & bulk)
6. ✅ Admin dapat filter publikasi by kategori, tahun, status
7. ✅ Admin dapat search publikasi by judul
8. ✅ File PDF dan thumbnail ter-upload ke storage
9. ✅ File ter-hapus otomatis saat delete publikasi
10. ✅ Dashboard menampilkan total publikasi
11. ✅ Navigation highlighting works correctly

## 🔧 Technical Implementation

### Cache Handling
Setiap create/update/delete publikasi akan clear cache:
```php
Cache::forget('home.publikasi');
Cache::forget('profil_desa');
```

### File Upload Path
- **PDF**: `storage/app/public/publikasi/{filename}.pdf`
- **Thumbnail**: `storage/app/public/publikasi/thumbnails/{filename}.jpg`

### AJAX Bulk Delete
JavaScript menggunakan Fetch API untuk bulk delete:
```javascript
fetch('{{ route("admin.publikasi.bulk-delete") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ ids: ids })
})
```

### Form File Display
JavaScript untuk display selected filename dengan size:
```javascript
function displayFileName(inputId, displayId) {
    const fileName = input.files[0].name;
    const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
    display.textContent = `${fileName} (${fileSize} MB)`;
}
```

## 📝 Notes

- Default status: Published (untuk kemudahan admin)
- Draft tidak muncul di halaman publik
- Thumbnail optional, akan menggunakan default jika kosong
- Tahun bisa hingga 5 tahun ke depan untuk perencanaan
- File dokumen wajib saat create, optional saat edit
- Search case-insensitive menggunakan LIKE query

## 🎯 Next Steps (Optional Enhancement)

Berikut adalah enhancement yang bisa ditambahkan di masa depan:
- [ ] Preview PDF di admin (modal/inline viewer)
- [ ] Export list publikasi ke Excel
- [ ] Batch upload multiple publikasi
- [ ] Publikasi revision history
- [ ] Download statistics chart
- [ ] Email notification saat publikasi baru
- [ ] Auto-generate thumbnail dari PDF cover

## ✅ Completion Summary

**Semua fitur admin publikasi sudah selesai dan terintegrasi dengan sempurna!**

Admin sekarang bisa:
1. Akses menu Publikasi dari sidebar ✅
2. Quick access via dashboard quick action ✅
3. Upload dokumen publikasi dengan PDF ✅
4. Edit publikasi dengan preview ✅
5. Delete (single & bulk) dengan file cleanup ✅
6. Filter & search publikasi ✅
7. Lihat statistics di dashboard ✅

System ready untuk production! 🚀
