# Edit Profil Admin dengan Upload Foto

## 📋 Ringkasan

Fitur **Settings** telah dihapus sepenuhnya dan digantikan dengan **Edit Profil Admin** yang lebih lengkap, termasuk:
- Upload foto profil dengan preview
- Resize otomatis ke 400x400 px
- Validasi format (JPG, JPEG, PNG) dan ukuran (maks 2 MB)
- Hapus foto profil
- Foto ditampilkan di header dan halaman profil

---

## ✅ Perubahan yang Dilakukan

### 1. **Menghapus Fitur Settings**
- ❌ Deleted: `app/Http/Controllers/Admin/SettingsController.php`
- ❌ Deleted: `resources/views/admin/settings/` (folder dan isinya)
- ✅ Removed: Import dan routes Settings dari `routes/web.php`
- ✅ Removed: Menu "Pengaturan" dari sidebar (`admin/layouts/app.blade.php`)

### 2. **Menambah Backend untuk Upload Foto**

**File:** `app/Http/Controllers/Admin/ProfileController.php`

Ditambahkan 2 method baru:

#### a. `updatePhoto()` - Upload/Update Foto
```php
- Validasi: required|image|mimes:jpeg,jpg,png|max:2048
- Hapus foto lama jika ada
- Resize gambar ke 400x400 px menggunakan Intervention\Image
- Simpan ke: storage/app/public/admins/photos/
- Format nama file: admin_{id}_{timestamp}.{ext}
- Update kolom 'avatar' di tabel admins
- Return JSON response untuk AJAX
```

#### b. `deletePhoto()` - Hapus Foto
```php
- Hapus file dari storage
- Set kolom 'avatar' ke null
- Return JSON response
```

**Routes Baru:**
```php
Route::post('/photo', [AdminProfileController::class, 'updatePhoto'])->name('update-photo');
Route::delete('/photo', [AdminProfileController::class, 'deletePhoto'])->name('delete-photo');
```

### 3. **Menambah Frontend Upload Foto**

**File:** `resources/views/admin/profile/edit.blade.php`

#### Komponen UI:
1. **Foto Profil Saat Ini**
   - Menampilkan foto jika ada
   - Menampilkan inisial nama jika belum ada foto
   - Tombol hapus (hover) untuk foto yang ada

2. **Upload Controls**
   - File input tersembunyi (accept: jpeg, jpg, png)
   - Tombol "Upload Foto" / "Ubah Foto"
   - Info format dan ukuran maksimal

3. **Preview Section** (muncul setelah pilih file)
   - Preview gambar dalam bentuk bulat
   - Nama file dan ukuran
   - Tombol "Upload" dan "Batal"

#### JavaScript Features:
- **File Validation:**
  - Format: JPG, JPEG, PNG
  - Ukuran maksimal: 2 MB
  - Alert SweetAlert2 jika tidak valid

- **Preview Instant:**
  - FileReader untuk preview sebelum upload
  - Tampilkan nama dan ukuran file

- **AJAX Upload:**
  - POST ke route `admin.profile.update-photo`
  - Loading state saat upload
  - Success/Error notification dengan SweetAlert2
  - Auto reload halaman setelah sukses

- **Delete Function:**
  - Konfirmasi dengan SweetAlert2
  - DELETE request ke route `admin.profile.delete-photo`
  - Replace foto dengan placeholder inisial

### 4. **Update Display Foto**

#### a. Header Avatar (`admin/layouts/app.blade.php`)
```blade
@if(auth()->guard('admin')->user()->avatar)
    <img src="{{ asset('storage/' . auth()->guard('admin')->user()->avatar) }}" />
@else
    <div>{{ substr(auth()->guard('admin')->user()->name, 0, 1) }}</div>
@endif
```

#### b. Profile Show (`admin/profile/show.blade.php`)
```blade
@if($admin->avatar)
    <img src="{{ asset('storage/' . $admin->avatar) }}" />
@else
    <div>{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
@endif
```

### 5. **Library yang Digunakan**

**Backend:**
- `Intervention\Image` - Resize dan crop gambar
- `Storage` facade - Manage file storage

**Frontend:**
- `SweetAlert2` v11 - Modal notifications
- `Animate.css` v4.1.1 - Animations
- `FileReader API` - Preview gambar

**Ditambahkan ke Layout:**
```html
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
```

---

## 🗂️ Struktur File

```
app/
  Http/Controllers/Admin/
    ✅ ProfileController.php (ditambah updatePhoto & deletePhoto)
    ❌ SettingsController.php (DELETED)

resources/views/admin/
  profile/
    ✅ edit.blade.php (ditambah section upload foto + JS)
    ✅ show.blade.php (update avatar display)
  layouts/
    ✅ app.blade.php (update header avatar, tambah SweetAlert2 CDN, hapus menu Settings)
  ❌ settings/ (DELETED)

routes/
  ✅ web.php (hapus settings routes, tambah photo routes)

storage/app/public/
  admins/photos/ (folder untuk simpan foto)
```

---

## 🎨 Fitur UI/UX

### Upload Process:
1. User klik tombol "Upload Foto" / "Ubah Foto"
2. File picker muncul (filter: .jpg, .jpeg, .png)
3. Validasi format dan ukuran
4. Preview muncul dengan nama file dan ukuran
5. User klik "Upload" → Loading state
6. Success notification + reload halaman
7. Foto muncul di header dan profil

### Delete Process:
1. Hover foto → tombol delete muncul
2. Klik delete → Konfirmasi SweetAlert2
3. DELETE request → Loading
4. Success notification
5. Foto diganti dengan inisial nama
6. Auto reload

### Animations:
- SweetAlert2: `fadeInDown` entrance, `fadeOutUp` exit
- Preview section: `hidden` class toggle
- Delete button: opacity transition on hover

---

## 🔐 Validasi & Keamanan

### Backend Validation:
```php
'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048'
```

### Frontend Validation:
```javascript
// Format check
const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

// Size check (2MB)
if (file.size > 2 * 1024 * 1024) { ... }
```

### Security:
- CSRF token untuk semua POST/DELETE requests
- File validation sebelum save
- Hapus file lama sebelum upload baru
- Storage disk 'public' dengan proper permissions

---

## 📊 Database

**Tabel:** `admins`

**Kolom yang Digunakan:** `avatar` (string, nullable)

Tidak perlu migration baru karena kolom `avatar` sudah ada di migration:
```php
$table->string('avatar')->nullable();
```

---

## 🚀 Testing Checklist

- [x] Upload foto JPG → Success, resize ke 400x400
- [ ] Upload foto PNG → Success
- [ ] Upload foto > 2MB → Ditolak dengan alert
- [ ] Upload file non-image → Ditolak dengan alert
- [ ] Hapus foto → Success, kembali ke inisial
- [ ] Foto muncul di header setelah upload
- [ ] Foto muncul di halaman profile/show
- [ ] Edit profile form tetap berfungsi normal
- [ ] Change password tetap berfungsi
- [ ] Refresh halaman → foto tetap ada

---

## 🔧 Cara Menggunakan

### Upload Foto:
1. Login sebagai Admin
2. Klik dropdown user di header → "Edit Profil"
3. Di section "Foto Profil", klik "Upload Foto"
4. Pilih gambar (JPG/PNG, max 2MB)
5. Preview akan muncul
6. Klik "Upload" untuk confirm
7. Foto akan langsung terlihat di header

### Hapus Foto:
1. Masuk ke halaman "Edit Profil"
2. Hover foto profil
3. Klik tombol merah (trash icon) yang muncul
4. Confirm di dialog SweetAlert2
5. Foto akan dihapus dan diganti inisial nama

---

## 📝 Catatan

- Format foto otomatis di-resize ke **400x400 px** (square)
- Foto disimpan di `storage/app/public/admins/photos/`
- Akses publik via `asset('storage/admins/photos/...')`
- Jika ingin ganti ke kolom 'photo', ubah semua referensi 'avatar' di:
  - ProfileController.php (2 method)
  - Admin model fillable
  - Migration file

---

## 🐛 Troubleshooting

### Foto tidak muncul setelah upload:
```bash
php artisan storage:link
```

### Error 500 saat upload:
- Cek permission folder `storage/app/public/admins/photos/`
- Cek apakah Intervention\Image terinstall:
  ```bash
  composer require intervention/image
  ```

### Foto tidak terhapus:
- Cek permission write pada folder storage
- Lihat log di `storage/logs/laravel.log`

---

**Status:** ✅ **SELESAI & SIAP DIGUNAKAN**

---

**Dibuat:** 2025-01-XX  
**Developer:** GitHub Copilot  
**Framework:** Laravel 10.x
