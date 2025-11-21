# 📱 Floating Action Button (FAB) WhatsApp

## Deskripsi
Tombol WhatsApp yang selalu muncul di pojok kanan bawah pada semua halaman public untuk memudahkan pengunjung melakukan tanya jawab dan pengaduan.

## Fitur
- ✅ **Fixed Position**: Selalu terlihat di kanan bawah saat scroll
- ✅ **Auto Redirect**: Langsung ke WhatsApp saat diklik
- ✅ **Responsive**: Bekerja di semua ukuran layar
- ✅ **Animasi**: Pulse animation dan hover effects
- ✅ **Tooltip**: Menampilkan "Tanya Jawab & Pengaduan" saat hover
- ✅ **Customizable**: Nomor WA bisa diubah via .env

## Cara Mengubah Nomor WhatsApp

### 1. Edit File `.env`
Buka file `.env` dan ubah nomor WhatsApp:

```env
# Format: 62 (kode negara) + nomor tanpa 0 di depan
# Contoh: 081234567890 → 6281234567890
WHATSAPP_NUMBER=6285123456789
WHATSAPP_MESSAGE="Halo Admin Desa Warurejo, saya ingin bertanya"
```

### 2. Clear Cache (Jika Perlu)
Setelah mengubah `.env`, jalankan:
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Refresh Browser
Buka website dan coba klik tombol WhatsApp untuk memastikan nomor sudah berubah.

## Konfigurasi Lanjutan

### Mengubah Pesan Default
Edit di `.env`:
```env
WHATSAPP_MESSAGE="Pesan custom Anda di sini"
```

### Mengubah Warna Button
Edit file: `resources/views/public/layouts/app.blade.php`
```html
<!-- Ganti bg-green-500 dengan warna lain -->
<a class="... bg-green-500 hover:bg-green-600 ...">
```

### Mengubah Posisi Button
Edit file: `resources/views/public/layouts/app.blade.php`
```html
<!-- Default: bottom-6 right-6 -->
<!-- Kiri bawah: bottom-6 left-6 -->
<!-- Kanan atas: top-6 right-6 -->
<div class="fixed bottom-6 right-6 z-50 group">
```

## Struktur File

```
config/
  └── contact.php              # Konfigurasi kontak (WhatsApp, email, phone)

resources/views/public/layouts/
  └── app.blade.php            # Layout utama dengan FAB

tailwind.config.js             # Custom shadow & animation
.env                           # Environment variables
```

## Testing

1. **Buka halaman public** (beranda, berita, potensi, galeri)
2. **Scroll ke bawah** - Tombol harus tetap terlihat
3. **Hover mouse** - Tooltip "Tanya Jawab & Pengaduan" muncul
4. **Klik tombol** - WhatsApp Web/App terbuka dengan pesan otomatis

## Troubleshooting

### Tombol Tidak Muncul
- Pastikan file sudah di-build: `npm run build`
- Clear browser cache: Ctrl + Shift + R
- Periksa console browser untuk error

### WhatsApp Tidak Terbuka
- Periksa format nomor di `.env` (harus 62xxx tanpa +)
- Pastikan nomor aktif dan terdaftar di WhatsApp
- Test link manual: `https://wa.me/62xxx`

### Animasi Tidak Bekerja
- Build ulang Tailwind: `npm run build`
- Clear cache: `php artisan config:clear`

## Browser Support
- ✅ Chrome/Edge (Desktop & Mobile)
- ✅ Firefox (Desktop & Mobile)
- ✅ Safari (Desktop & Mobile)
- ✅ Opera

## Mobile Behavior
- Android: Buka WhatsApp app langsung
- iOS: Buka WhatsApp app langsung
- Desktop: Buka WhatsApp Web

## Accessibility
- ARIA label: "Hubungi via WhatsApp"
- Keyboard accessible
- Screen reader friendly
