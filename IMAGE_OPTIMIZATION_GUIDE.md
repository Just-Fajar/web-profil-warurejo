# Image Optimization Guide

## Overview
This guide explains how to use the image optimization command to resize existing images and generate WebP versions for better performance.

## Command Usage

### Basic Syntax
```bash
php artisan images:optimize [options]
```

### Available Options

| Option | Default | Description |
|--------|---------|-------------|
| `--type=` | `all` | Type of images to optimize (`all`, `berita`, `potensi`, `galeri`) |
| `--max-width=` | `1200` | Maximum width for images (in pixels) |
| `--quality=` | `85` | JPEG quality (1-100, higher = better quality) |
| `--webp` | `false` | Generate WebP versions of images |
| `--webp-quality=` | `80` | WebP quality (1-100, higher = better quality) |

## Usage Examples

### 1. Optimize All Images
Resize all images to 1200px width with 85% quality:
```bash
php artisan images:optimize
```

### 2. Optimize Only Berita Images
```bash
php artisan images:optimize --type=berita
```

### 3. Custom Width and Quality
Resize to 800px with 90% quality:
```bash
php artisan images:optimize --max-width=800 --quality=90
```

### 4. Generate WebP Versions
Create WebP versions alongside original images:
```bash
php artisan images:optimize --webp
```

### 5. WebP with Custom Quality
```bash
php artisan images:optimize --webp --webp-quality=85
```

### 6. Full Optimization
Resize, compress, and generate WebP:
```bash
php artisan images:optimize --max-width=1200 --quality=85 --webp --webp-quality=80
```

### 7. Optimize Specific Type with WebP
```bash
php artisan images:optimize --type=galeri --webp
```

## What It Does

### Image Resizing
- Resizes images larger than `max-width` to the specified width
- Maintains aspect ratio (proportional height)
- Skips images already smaller than `max-width`
- Compresses JPEG and PNG files

### WebP Generation
When `--webp` flag is used:
- Creates `.webp` version alongside original image
- Same filename but with `.webp` extension
- Usually 25-35% smaller than JPEG
- Skips if WebP already exists

### File Organization
```
storage/app/public/
├── berita/
│   ├── image1.jpg          # Original (optimized)
│   ├── image1.webp         # WebP version (if --webp used)
│   └── image2.jpg
├── potensi/
│   ├── potential1.jpg
│   └── potential1.webp
└── galeri/
    ├── gallery1.jpg
    └── gallery1.webp
```

## Performance Benefits

### Before Optimization
- Large images: 3-5 MB each
- Slow page load: 5-10 seconds
- High bandwidth usage
- Poor mobile experience

### After Optimization
- Optimized images: 200-500 KB each
- Fast page load: 1-2 seconds
- 70-90% less bandwidth
- Great mobile experience

### WebP Benefits
- 25-35% smaller than JPEG
- Better compression than PNG
- Modern browser support (95%+)
- Automatic fallback to original

## Output Example

```bash
$ php artisan images:optimize --webp

Starting image optimization...
Type: all | Max Width: 1200px | Quality: 85%
WebP generation: ENABLED | WebP Quality: 80%

📰 Optimizing Berita images...
  ✅ Optimized: Berita: Pembangunan Jalan Desa
      2400x1800 → 1200x900
      3.2 MB → 450 KB (saved 85.9%)
      🌐 WebP created: 320 KB (saved 28.9%)
  
  ⏭️  Already optimized: Berita: Kegiatan Posyandu (800x600)
      🌐 WebP created: 180 KB (saved 25.0%)

🌾 Optimizing Potensi images...
  ✅ Optimized: Potensi: Pertanian Padi
      3000x2000 → 1200x800
      4.5 MB → 520 KB (saved 88.4%)
      🌐 WebP created: 380 KB (saved 26.9%)

📸 Optimizing Galeri images...
  ✅ Optimized: Galeri: Kegiatan Kerja Bakti
      2048x1536 → 1200x900
      2.8 MB → 420 KB (saved 85.0%)
      🌐 WebP created: 310 KB (saved 26.2%)

Optimization complete!
+----------------+-------+
| Status         | Count |
+----------------+-------+
| Optimized      | 45    |
| Skipped        | 12    |
| Failed         | 0     |
| WebP Generated | 57    |
+----------------+-------+
```

## Best Practices

### 1. Backup First
```bash
# Backup your storage folder before running
cp -r storage/app/public storage/app/public.backup
```

### 2. Test on Development
```bash
# Test on small batch first
php artisan images:optimize --type=berita
```

### 3. Monitor Results
- Check a few optimized images manually
- Verify quality is acceptable
- Ensure WebP files are created

### 4. Production Optimization
```bash
# Full optimization for production
php artisan images:optimize --max-width=1200 --quality=85 --webp --webp-quality=80
```

### 5. Schedule Regular Optimization
Add to your deployment script:
```bash
php artisan images:optimize --webp
```

## Recommended Settings

### For Blog/News Images (Berita)
```bash
php artisan images:optimize \
  --type=berita \
  --max-width=1200 \
  --quality=85 \
  --webp \
  --webp-quality=80
```

### For Gallery Images (Galeri)
```bash
php artisan images:optimize \
  --type=galeri \
  --max-width=1600 \
  --quality=90 \
  --webp \
  --webp-quality=85
```

### For Thumbnails/Icons (Potensi)
```bash
php artisan images:optimize \
  --type=potensi \
  --max-width=800 \
  --quality=85 \
  --webp \
  --webp-quality=80
```

## Quality Guidelines

### JPEG Quality Settings
- **90-100%**: Maximum quality (large file size)
- **85-90%**: High quality (recommended for important images)
- **80-85%**: Good quality (recommended for most images)
- **70-80%**: Acceptable quality (smaller file size)
- **<70%**: Visible quality loss (not recommended)

### WebP Quality Settings
- **85-90%**: Excellent quality (similar to JPEG 95%)
- **80-85%**: Very good quality (recommended)
- **75-80%**: Good quality (good balance)
- **<75%**: Noticeable quality loss

## Troubleshooting

### Issue: "File not found"
**Cause:** Image file missing from storage
**Solution:** Check if file exists in `storage/app/public/`

### Issue: "Failed to optimize"
**Cause:** Corrupted image or unsupported format
**Solution:** 
- Check image file integrity
- Ensure format is JPG, PNG, or WebP
- Re-upload original image

### Issue: WebP not generated
**Cause:** GD/Imagick doesn't support WebP
**Solution:**
- Check PHP extensions: `php -m | grep -E 'gd|imagick'`
- Install WebP support: `sudo apt-get install libwebp-dev`
- Recompile PHP with WebP support

### Issue: Memory limit errors
**Cause:** Large images consuming too much memory
**Solution:**
```bash
# Increase memory limit temporarily
php -d memory_limit=512M artisan images:optimize
```

## Using WebP Images in Views

### Blade Template Example
```blade
<picture>
    {{-- WebP version for modern browsers --}}
    <source 
        srcset="{{ asset('storage/' . pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp') }}" 
        type="image/webp"
    >
    
    {{-- Fallback to original format --}}
    <img 
        src="{{ asset('storage/' . $image) }}" 
        alt="{{ $alt_text }}"
        loading="lazy"
    >
</picture>
```

### Helper Function (Optional)
Create in `app/Helpers/ImageHelper.php`:
```php
<?php

if (!function_exists('image_webp')) {
    function image_webp($path, $alt = '', $class = '') {
        $pathInfo = pathinfo($path);
        $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
        
        return '
            <picture>
                <source srcset="' . asset('storage/' . $webpPath) . '" type="image/webp">
                <img src="' . asset('storage/' . $path) . '" alt="' . $alt . '" class="' . $class . '" loading="lazy">
            </picture>
        ';
    }
}
```

Usage:
```blade
{!! image_webp($berita->gambar_utama, $berita->judul, 'w-full h-auto') !!}
```

## Maintenance Schedule

### Weekly
```bash
# Optimize any new uploads
php artisan images:optimize --webp
```

### Monthly
```bash
# Full re-optimization with updated settings
php artisan images:optimize --max-width=1200 --quality=85 --webp
```

### After Bulk Upload
```bash
# Optimize specific type immediately
php artisan images:optimize --type=galeri --webp
```

## Performance Metrics

### Expected Results
- **File size reduction:** 70-90%
- **WebP savings:** Additional 25-35%
- **Page load improvement:** 50-80% faster
- **Bandwidth savings:** 60-85% less data transfer

### Before/After Example
```
Original:    3.2 MB JPEG (2400x1800)
Optimized:   450 KB JPEG (1200x900) - 85.9% smaller
WebP:        320 KB WebP (1200x900) - 28.9% smaller than optimized
Total saving: 90% from original
```

## FAQ

**Q: Will this reduce image quality?**  
A: At 85% quality, the difference is barely noticeable to the human eye, but file size is significantly smaller.

**Q: Can I undo optimization?**  
A: Yes, if you backed up your images first. Otherwise, you'll need to re-upload originals.

**Q: Does this work on already optimized images?**  
A: The command skips images smaller than `max-width`, but you can still generate WebP versions.

**Q: How long does it take?**  
A: Depends on number and size of images. Typically:
- 100 images: 2-5 minutes
- 500 images: 10-15 minutes
- 1000 images: 20-30 minutes

**Q: Is WebP supported by all browsers?**  
A: WebP is supported by 95%+ of browsers (Chrome, Firefox, Edge, Safari 14+). The `<picture>` tag provides automatic fallback for older browsers.

**Q: Can I optimize during production?**  
A: Yes, but it's CPU-intensive. Run during off-peak hours or on a separate queue worker.

## Automation

### Laravel Scheduler
Add to `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    // Optimize new images weekly
    $schedule->command('images:optimize --webp')
        ->weekly()
        ->sundays()
        ->at('02:00');
}
```

### Deployment Script
Add to `deploy.sh`:
```bash
#!/bin/bash
echo "Optimizing images..."
php artisan images:optimize --webp --quiet
echo "Done!"
```

## Support

For issues or questions:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify PHP extensions: `php -m`
- Test with single image first
- Contact: adminwarurejo@gmail.com

---

**Last Updated:** 2025-01-XX  
**Version:** 1.0  
**Status:** Production Ready ✅
