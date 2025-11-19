<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'admin_id',
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Accessors
    public function getGambarUrlAttribute()
    {
        return $this->gambar 
            ? asset('storage/' . $this->gambar) 
            : asset('images/default-gallery.jpg');
    }

    public function getFormattedDateAttribute()
    {
        return $this->tanggal 
            ? $this->tanggal->format('d F Y') 
            : $this->created_at->format('d F Y');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('tanggal')
                  ->orWhere('tanggal', '<=', now());
            });
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');
    }

    // Constants for categories
    const KATEGORI_KEGIATAN = 'kegiatan';
    const KATEGORI_INFRASTRUKTUR = 'infrastruktur';
    const KATEGORI_BUDAYA = 'budaya';
    const KATEGORI_UMUM = 'umum';

    public static function getKategoriList()
    {
        return [
            self::KATEGORI_KEGIATAN => 'Kegiatan',
            self::KATEGORI_INFRASTRUKTUR => 'Infrastruktur',
            self::KATEGORI_BUDAYA => 'Budaya',
            self::KATEGORI_UMUM => 'Umum',
        ];
    }
}
