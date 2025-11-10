<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'admin_id',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar_utama',
        'status',
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Accessors
    public function getGambarUtamaUrlAttribute()
    {
        return $this->gambar_utama 
            ? asset('storage/' . $this->gambar_utama) 
            : asset('images/default-berita.jpg');
    }

    public function getExcerptAttribute()
    {
        return $this->ringkasan 
            ? $this->ringkasan 
            : Str::limit(strip_tags($this->konten), 150);
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('d F Y') 
            : $this->created_at->format('d F Y');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');
    }

    // Mutators
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Boot method for auto-generating slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
            
            // Ensure unique slug
            $originalSlug = $berita->slug;
            $count = 1;
            while (static::where('slug', $berita->slug)->exists()) {
                $berita->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });
    }
}
