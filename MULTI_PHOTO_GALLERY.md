# 📸 Multi-Photo Gallery Implementation

## ✅ Implementasi Lengkap

Fitur galeri sekarang mendukung **multiple photos per entry** tanpa toggle mode. Admin bisa langsung upload sebanyak mungkin foto dalam satu entry galeri.

---

## 🗄️ Database Schema

### Table: `galeri_images`
```sql
- id (bigint, primary key)
- galeri_id (bigint, foreign key to galeri.id, cascade delete)
- image_path (string) - path ke file gambar di storage
- urutan (integer, default 0) - urutan tampilan foto
- timestamps
```

**Indexes:**
- `galeri_id` - untuk query cepat
- `urutan` - untuk sorting

**Migration:** `2025_11_21_133645_create_galeri_images_table.php`

---

## 🏗️ Model Relationships

### Model: `Galeri`
```php
public function images()
{
    return $this->hasMany(GaleriImage::class)->orderBy('urutan');
}

// Accessor untuk backward compatibility
public function getGambarUrlAttribute()
{
    // Ambil foto pertama dari images
    if ($this->images && $this->images->count() > 0) {
        return $this->images->first()->image_url;
    }
    
    // Fallback ke gambar single
    return $this->gambar 
        ? asset('storage/' . $this->gambar) 
        : asset('images/default-gallery.jpg');
}
```

### Model: `GaleriImage`
```php
protected $fillable = ['galeri_id', 'image_path', 'urutan'];

public function galeri()
{
    return $this->belongsTo(Galeri::class);
}

public function getImageUrlAttribute()
{
    return asset('storage/' . $this->image_path);
}
```

---

## 📝 Form Upload (Admin Create)

### File: `resources/views/admin/galeri/create.blade.php`

**Input Field:**
```html
<input type="file" 
       id="multiGambar" 
       name="images[]" 
       accept="image/*" 
       multiple>
```

**Features:**
- ✅ Multiple file selection (`multiple` attribute)
- ✅ Array input (`name="images[]"`)
- ✅ Live preview grid dengan thumbnail
- ✅ Remove individual images sebelum submit
- ✅ Auto numbering urutan foto
- ✅ Validasi 2MB per file

**JavaScript Logic:**
```javascript
let selectedFiles = [];

// Tambah file ke array
document.getElementById('multiGambar').addEventListener('change', function(event) {
    const files = Array.from(event.target.files);
    
    files.forEach(file => {
        if (file.size > 2048000) {
            alert(`File ${file.name} terlalu besar (max 2MB)`);
            return;
        }
        
        if (!selectedFiles.find(f => f.name === file.name && f.size === file.size)) {
            selectedFiles.push(file);
        }
    });
    
    updatePreviewGrid();
    updateFileInput();
});

// Remove individual image
function removeImage(index) {
    selectedFiles.splice(index, 1);
    updatePreviewGrid();
    updateFileInput();
}
```

---

## 🔧 Controller Logic

### File: `app/Http/Controllers/Admin/GaleriController.php`

```php
use Illuminate\Support\Facades\DB;
use App\Models\GaleriImage;

public function store(GaleriRequest $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->validated();
        $data['admin_id'] = auth('admin')->id();
        
        // Create galeri record
        $galeri = Galeri::create($data);
        
        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $this->imageUploadService->upload($image, 'galeri');
                
                GaleriImage::create([
                    'galeri_id' => $galeri->id,
                    'image_path' => $imagePath,
                    'urutan' => $index + 1,
                ]);
            }
        }
        
        DB::commit();
        
        // Clear cache
        Cache::forget('home.galeri');
        Cache::forget('profil_desa');
        
        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
```

**Key Points:**
- ✅ Database transaction untuk data integrity
- ✅ Loop setiap file dari array `images[]`
- ✅ Auto-increment urutan (1, 2, 3, ...)
- ✅ Rollback jika error
- ✅ Cache invalidation

---

## ✅ Validation Rules

### File: `app/Http/Requests/GaleriRequest.php`

```php
public function rules(): array
{
    $galeriId = $this->route('galeri') ? $this->route('galeri')->id : null;
    
    $rules = [
        'judul' => 'required|string|max:255',
        'kategori' => 'required|in:kegiatan,infrastruktur,budaya,umkm,lainnya',
        'deskripsi' => 'nullable|string',
        'tanggal' => 'required|date',
        'is_active' => 'required|boolean',
    ];

    // Multiple images validation
    if ($galeriId) {
        // Update: images optional
        $rules['images'] = 'nullable|array|min:1';
        $rules['images.*'] = 'image|mimes:jpeg,png,jpg,webp|max:2048';
    } else {
        // Create: images required
        $rules['images'] = 'required|array|min:1';
        $rules['images.*'] = 'image|mimes:jpeg,png,jpg,webp|max:2048';
    }

    return $rules;
}
```

**Validasi:**
- `images` harus array minimal 1 item (create) atau nullable (edit)
- `images.*` setiap file harus image, max 2MB, format jpeg/png/jpg/webp

---

## 🖼️ Public Display

### File: `resources/views/public/galeri/index.blade.php`

**Features:**
1. **Card View:**
   - Thumbnail menampilkan foto pertama
   - Badge "X Foto" jika lebih dari 1 foto
   
2. **Lightbox Modal dengan Carousel:**
   - Navigate prev/next dengan arrow buttons
   - Counter "1 / 5" untuk tracking posisi
   - Smooth transition antar foto
   - Click backdrop untuk close

**Alpine.js Data:**
```javascript
x-data="{ 
    openModal: false, 
    modalImages: [],  // Array of image URLs
    modalTitle: '', 
    modalDesc: '',
    currentIndex: 0   // Carousel position
}"
```

**Click Event:**
```javascript
@click="
    openModal = true; 
    modalImages = @js($galeri->images->map(...)->toArray()); 
    modalTitle = '...'; 
    modalDesc = '...';
    currentIndex = 0;
"
```

---

## 📊 Admin Index View

### File: `resources/views/admin/galeri/index.blade.php`

**Display Changes:**
```blade
@if($item->images && $item->images->count() > 0)
    <img src="{{ $item->images->first()->image_url }}" ...>
    
    @if($item->images->count() > 1)
        <span class="badge">
            <i class="fas fa-images"></i> {{ $item->images->count() }} Foto
        </span>
    @endif
@else
    <div class="placeholder">
        <i class="fas fa-image"></i>
    </div>
@endif
```

---

## 🔄 Eager Loading (N+1 Prevention)

### Admin Controller:
```php
$galeri = Galeri::with(['admin', 'images'])->latest()->get();
```

### Public Controller:
```php
$galeris = Galeri::with(['admin', 'images'])->published()->latest()->paginate(24);
```

**Query Optimization:**
- Load relasi `images` sekaligus
- Prevent N+1 query problem
- Order by urutan otomatis (defined in relationship)

---

## 📁 File Structure

```
app/
  Models/
    ├── Galeri.php (updated: images() relationship)
    └── GaleriImage.php (new)
  
  Http/
    Controllers/
      Admin/
        └── GaleriController.php (updated: store with multiple upload)
      Public/
        └── GaleriController.php (updated: eager load images)
    
    Requests/
      └── GaleriRequest.php (updated: validate images array)

database/
  migrations/
    └── 2025_11_21_133645_create_galeri_images_table.php

resources/
  views/
    admin/
      galeri/
        ├── create.blade.php (updated: multiple upload form)
        ├── edit.blade.php (TODO: belum di-update)
        └── index.blade.php (updated: show badge jumlah foto)
    
    public/
      galeri/
        └── index.blade.php (updated: carousel modal)
```

---

## 🧪 Testing

### Manual Testing Steps:

1. **Login Admin** → `/admin/login`

2. **Create Galeri** → `/admin/galeri/create`
   - Upload 3-5 foto sekaligus
   - Verify preview grid muncul
   - Verify numbering (1, 2, 3, ...)
   - Test remove individual image
   - Submit form

3. **Admin Index** → `/admin/galeri`
   - Verify badge "X Foto" muncul
   - Verify thumbnail foto pertama tampil

4. **Public Galeri** → `/galeri`
   - Verify card show badge "X Foto"
   - Click card → Modal terbuka
   - Verify carousel navigation (prev/next)
   - Verify counter "1 / 5"

5. **Database Check:**
```sql
SELECT * FROM galeri ORDER BY id DESC LIMIT 1;
SELECT * FROM galeri_images WHERE galeri_id = [LAST_ID];
```

---

## 🚀 Next Steps (TODO)

### 1. Update Edit Form
File: `resources/views/admin/galeri/edit.blade.php`

**Requirements:**
- Show existing images in sortable grid
- Allow delete individual images
- Allow add more images
- Drag-drop untuk reorder urutan

### 2. Update Controller `update()` Method
```php
public function update(GaleriRequest $request, Galeri $galeri)
{
    DB::beginTransaction();
    
    // Update galeri data
    $galeri->update($request->validated());
    
    // Handle deleted images (from request 'deleted_images[]')
    if ($request->has('deleted_images')) {
        foreach ($request->deleted_images as $imageId) {
            $image = GaleriImage::find($imageId);
            if ($image && $image->galeri_id == $galeri->id) {
                Storage::delete($image->image_path);
                $image->delete();
            }
        }
    }
    
    // Handle new images
    if ($request->hasFile('images')) {
        $maxUrutan = $galeri->images()->max('urutan') ?? 0;
        
        foreach ($request->file('images') as $index => $file) {
            $imagePath = $this->imageUploadService->upload($file, 'galeri');
            
            GaleriImage::create([
                'galeri_id' => $galeri->id,
                'image_path' => $imagePath,
                'urutan' => $maxUrutan + $index + 1,
            ]);
        }
    }
    
    // Handle reordering (from request 'image_order[]')
    if ($request->has('image_order')) {
        foreach ($request->image_order as $index => $imageId) {
            GaleriImage::where('id', $imageId)
                ->where('galeri_id', $galeri->id)
                ->update(['urutan' => $index + 1]);
        }
    }
    
    DB::commit();
}
```

### 3. Migration Untuk Data Existing

Jika ada galeri lama dengan field `gambar` (single photo):

```php
// Migration: migrate_old_galeri_to_images
public function up()
{
    $galeris = Galeri::whereNotNull('gambar')->get();
    
    foreach ($galeris as $galeri) {
        GaleriImage::create([
            'galeri_id' => $galeri->id,
            'image_path' => $galeri->gambar,
            'urutan' => 1,
        ]);
    }
}
```

### 4. Delete Cascade Handling

Sudah terimplementasi di migration:
```php
$table->foreignId('galeri_id')
      ->constrained('galeri')
      ->onDelete('cascade');
```

Saat galeri dihapus, semua images otomatis terhapus dari database.

**TODO:** Update `GaleriController@destroy` untuk hapus files:
```php
public function destroy(Galeri $galeri)
{
    // Delete all image files
    foreach ($galeri->images as $image) {
        Storage::delete($image->image_path);
    }
    
    // Delete galeri (images will cascade delete)
    $galeri->delete();
}
```

---

## 📈 Benefits

✅ **User Experience:**
- Admin bisa upload banyak foto sekali jalan
- Tidak perlu create multiple entries untuk 1 event
- Live preview sebelum submit

✅ **Performance:**
- Eager loading prevents N+1
- Indexed foreign keys
- Efficient carousel navigation

✅ **Data Integrity:**
- Transaction untuk atomicity
- Cascade delete
- File validation per-item

✅ **Maintainability:**
- Clean model relationships
- Separation of concerns
- Reusable ImageUploadService

---

## 🎯 Summary

Fitur multi-photo gallery sekarang **fully functional** untuk:
- ✅ Upload multiple photos (create)
- ✅ Display di admin index dengan badge
- ✅ Display di public dengan carousel modal
- ✅ Database relationships & eager loading
- ✅ File validation & error handling

**Pending:**
- ⏳ Edit form dengan add/delete/reorder
- ⏳ Bulk operations
- ⏳ Drag-drop sorting UI
- ⏳ Migration data lama

---

## 📞 Support

Jika ada bug atau pertanyaan:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console untuk JS errors
3. Verify migration: `php artisan migrate:status`
4. Test dengan fresh data entry

**Happy Coding! 🚀**
