# 🚀 Quick Start Guide - Struktur Organisasi

## Cara Menggunakan Fitur Struktur Organisasi

### 1. Akses Admin Panel
```
URL: http://localhost/WebDesaWarurejo/admin/struktur-organisasi
```

### 2. Menambah Anggota Baru
1. Klik tombol **"Tambah Anggota"** di kanan atas
2. Isi form:
   - **Nama**: Nama lengkap anggota
   - **Jabatan**: Contoh: "Kepala Desa", "Kaur Keuangan", dll
   - **Level**: Pilih tingkatan (Kepala Desa, Sekretaris, Kaur, Staff Kaur, Kasi, Staff Kasi)
   - **Atasan** (opsional): Pilih atasan jika ada
   - **Foto**: Upload foto profil (max 2MB)
   - **Deskripsi** (opsional): Keterangan tambahan
   - **Urutan**: Untuk sorting tampilan (angka kecil = atas)
   - **Status**: Aktif/Tidak Aktif
3. Klik **"Simpan"**

### 3. Mengedit Anggota
1. Pada tabel, klik icon **Edit (pensil)** di kolom Aksi
2. Update data yang diinginkan
3. Untuk mengganti foto, upload foto baru (kosongkan jika tidak ingin ganti)
4. Klik **"Simpan"**

### 4. Menghapus Anggota
**Single Delete:**
1. Klik icon **Hapus (tempat sampah)** di kolom Aksi
2. Konfirmasi penghapusan
3. Data dan foto akan terhapus

**Bulk Delete:**
1. Centang checkbox di samping anggota yang ingin dihapus
2. Klik tombol **"Hapus Dipilih (X)"** yang muncul
3. Konfirmasi penghapusan massal
4. Semua data terpilih akan dihapus

### 5. Mencari & Filter
**Search:**
- Ketik nama atau jabatan di kolom search
- Hasil akan filter secara real-time

**Filter by Level:**
- Gunakan dropdown "Semua Level"
- Pilih level tertentu (Kepala Desa, Kaur, Kasi, dll)

**Filter by Status:**
- Gunakan dropdown "Semua Status"
- Pilih Aktif atau Tidak Aktif

### 6. Urutan Tampilan
Anggota akan tampil berurutan berdasarkan:
1. **Level** (Kepala → Sekretaris → Kaur → Staff Kaur → Kasi → Staff Kasi)
2. **Urutan** (angka kecil ke besar)
3. **Nama** (A-Z)

## 📊 Struktur Level

```
Kepala Desa (kepala)
    ↓
Sekretaris Desa (sekretaris)
    ↓
├── Kepala Urusan (kaur)
│   └── Staff Kaur (staff_kaur)
│
└── Kepala Seksi (kasi)
    └── Staff Kasi (staff_kasi)
```

## 💡 Tips & Best Practices

### Upload Foto
- **Format**: JPG, PNG, atau WEBP
- **Ukuran Max**: 2MB
- **Resolusi**: Akan otomatis di-resize ke 800x800 pixels
- **Tips**: Gunakan foto dengan rasio 1:1 (kotak) untuk hasil terbaik

### Urutan yang Baik
```
Kepala Desa:        urutan = 0
Sekretaris:         urutan = 10
Kaur Keuangan:      urutan = 20
Kaur Perencanaan:   urutan = 21
Kaur TU:            urutan = 22
Staff Keuangan:     urutan = 30
Kasi Pemerintahan:  urutan = 40
Kasi Kesejahteraan: urutan = 41
Kasi Pelayanan:     urutan = 42
Staff Kesejahteraan:urutan = 50
```
*Beri jarak (10, 20, dst) untuk fleksibilitas penambahan di tengah*

### Status Aktif/Tidak Aktif
- **Aktif**: Akan ditampilkan di halaman publik
- **Tidak Aktif**: Hanya tersimpan di database, tidak tampil di publik
- Gunakan "Tidak Aktif" untuk anggota yang sudah pensiun/pindah tapi ingin historynya tersimpan

## 🔍 Troubleshooting

### Foto Tidak Muncul
1. Pastikan file format benar (jpg/png/webp)
2. Cek ukuran file (max 2MB)
3. Pastikan folder `storage/struktur-organisasi` ada dan writable

### Tidak Bisa Upload
```bash
# Jalankan command ini jika folder storage tidak ada
cd c:\xampp\htdocs\WebDesaWarurejo
php artisan storage:link
```

### Data Tidak Muncul di Publik
1. Cek status anggota: harus **Aktif**
2. Refresh halaman publik: `/profil/struktur-organisasi`
3. Clear cache jika perlu:
```bash
php artisan cache:clear
```

## 📱 Fitur yang Tersedia

✅ CRUD lengkap (Create, Read, Update, Delete)
✅ Upload & preview foto
✅ Optimasi image otomatis
✅ Search real-time
✅ Filter by level & status
✅ Bulk delete
✅ Statistics dashboard
✅ Validation lengkap
✅ Konfirmasi sebelum delete
✅ Notifikasi sukses/error
✅ Pagination
✅ Hierarchical structure (atasan/bawahan)

## 🎯 Contoh Data

### Kepala Desa
- Nama: SUNARTO
- Jabatan: Kepala Desa Warurejo
- Level: Kepala Desa
- Urutan: 0
- Status: Aktif

### Sekretaris Desa
- Nama: HAYYUN JOKO IRAWAN
- Jabatan: PLT. Sekretaris Desa
- Level: Sekretaris Desa
- Urutan: 10
- Status: Aktif

### Kaur Keuangan
- Nama: PARTINI
- Jabatan: Kaur Keuangan
- Level: Kepala Urusan
- Urutan: 20
- Status: Aktif

### Staff Keuangan
- Nama: SETIYO PARYONO
- Jabatan: Staff Keuangan
- Level: Staff Kaur
- Atasan: PARTINI (Kaur Keuangan)
- Urutan: 30
- Status: Aktif

---

**Butuh bantuan?** Hubungi developer atau lihat dokumentasi lengkap di `STRUKTUR_ORGANISASI_CRUD_COMPLETE.md`
