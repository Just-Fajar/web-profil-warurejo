# Fitur Kontak WhatsApp untuk Potensi Desa

## Deskripsi
Fitur ini menambahkan field nomor WhatsApp pada setiap Potensi Desa yang memungkinkan pengunjung untuk langsung menghubungi via WhatsApp dengan sekali klik.

## Fitur yang Ditambahkan

### 1. Database
- **Tabel**: `potensi_desa`
- **Field Baru**: `whatsapp` (VARCHAR 20, nullable)
- **Posisi**: Setelah field `kontak`

### 2. Form Admin (Create & Edit)
- Input field untuk nomor WhatsApp dengan prefix `+62`
- Auto-format: Menghapus leading 0 atau +62 yang dimasukkan user
- Validasi: Hanya menerima angka (0-9)
- Maksimal 15 digit
- Field bersifat opsional

#### Format Input:
```
+62 [8123456789]
    └── User input tanpa 0 atau 62
```

### 3. Tampilan Public (Detail Potensi)

#### A. Section Informasi Kontak
Jika ada nomor WhatsApp, akan muncul tombol hijau dengan:
- Icon WhatsApp
- Text: "Chat via WhatsApp: +62xxxxxxxxx"
- Klik langsung membuka WhatsApp dengan template pesan

#### B. CTA Card (Call to Action)
Tombol besar "Hubungi Kami via WhatsApp" yang:
- Prioritas menggunakan nomor WhatsApp dari database
- Fallback ke nomor default (6283114796959) jika tidak ada
- Template pesan sudah include nama potensi

### 4. Template Pesan WhatsApp
```
Halo, saya tertarik dengan [Nama Potensi]
```

## Cara Penggunaan

### Sebagai Admin:

1. **Tambah/Edit Potensi Desa**
   - Buka form Create atau Edit Potensi
   - Scroll ke field "Nomor WhatsApp"
   - Masukkan nomor tanpa 0 atau +62
   - Contoh: `8123456789` (bukan 08123456789 atau +628123456789)

2. **Auto-format Input**
   - Jika ketik `0812...` → otomatis jadi `812...`
   - Jika ketik `62812...` → otomatis jadi `812...`
   - Hanya angka yang diterima

### Sebagai Pengunjung:

1. **Buka Detail Potensi**
2. **Scroll ke Section Informasi Kontak**
3. **Klik tombol hijau "Chat via WhatsApp"**
4. **WhatsApp terbuka otomatis** dengan:
   - Nomor tujuan: +62xxxxxxxxx
   - Pesan template siap kirim

## Validasi

### Frontend (JavaScript)
- Real-time validation saat mengetik
- Auto-remove karakter non-numeric
- Auto-remove prefix 0 atau 62
- Max length 15 digit

### Backend (Model)
- Field `whatsapp` nullable (opsional)
- Max length 20 characters

## Link Format WhatsApp
```
https://wa.me/62[nomor]?text=[pesan]
```

**Contoh:**
```
https://wa.me/628123456789?text=Halo,%20saya%20tertarik%20dengan%20Pertanian%20Padi%20Organik
```

## File yang Dimodifikasi

1. **Migration**: `2025_11_18_120147_add_whatsapp_to_potensi_desa_table.php`
2. **Model**: `app/Models/PotensiDesa.php` (tambah fillable)
3. **Admin Create**: `resources/views/admin/potensi/create.blade.php`
4. **Admin Edit**: `resources/views/admin/potensi/edit.blade.php`
5. **Public Show**: `resources/views/public/potensi/show.blade.php`

## Keuntungan Fitur

✅ **User-Friendly**: Satu klik langsung chat WhatsApp
✅ **Auto-Format**: Input nomor otomatis dirapikan
✅ **Template Pesan**: Pengunjung tidak perlu ketik manual
✅ **Opsional**: Field tidak wajib diisi
✅ **Fallback**: Ada nomor default jika tidak diisi
✅ **Responsive**: Bekerja di desktop dan mobile

## Testing

1. Buat/Edit potensi desa, isi nomor WhatsApp: `8123456789`
2. Simpan
3. Buka halaman detail potensi di public view
4. Klik tombol "Chat via WhatsApp"
5. Verifikasi WhatsApp terbuka dengan nomor: +628123456789
6. Verifikasi pesan template sudah terisi

## Catatan

- Nomor disimpan **tanpa prefix** di database (8xxx)
- Prefix +62 ditambahkan saat **generate link** WhatsApp
- Field `kontak` tetap ada untuk kontak umum (email/telp)
- Field `whatsapp` khusus untuk nomor WhatsApp

---

**Dibuat**: 18 November 2025
**Status**: ✅ Production Ready
