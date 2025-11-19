<?php

namespace App\Services;

use App\Repositories\BeritaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BeritaService
{
    protected $beritaRepository;
    protected $imageUploadService;
    protected $htmlSanitizer;

    public function __construct(
        BeritaRepository $beritaRepository,
        ImageUploadService $imageUploadService,
        HtmlSanitizerService $htmlSanitizer
    ) {
        $this->beritaRepository = $beritaRepository;
        $this->imageUploadService = $imageUploadService;
        $this->htmlSanitizer = $htmlSanitizer;
    }

    public function getAllBerita()
    {
        return $this->beritaRepository->all();
    }

    public function getPaginatedBerita($perPage = 15)
    {
        return $this->beritaRepository->paginate($perPage);
    }

    public function getPublishedBerita($perPage = 10)
    {
        return $this->beritaRepository->getPublished($perPage);
    }

    public function getBeritaById($id)
    {
        return $this->beritaRepository->find($id);
    }

    public function getBeritaBySlug($slug)
    {
        $berita = $this->beritaRepository->findBySlug($slug);
        $this->beritaRepository->incrementViews($berita->id);
        return $berita;
    }

    public function createBerita(array $data)
    {
        // Sanitize HTML content
        if (isset($data['konten'])) {
            $data['konten'] = $this->htmlSanitizer->sanitize($data['konten']);
        }
        if (isset($data['ringkasan'])) {
            $data['ringkasan'] = $this->htmlSanitizer->sanitize($data['ringkasan']);
        }

        if (isset($data['gambar_utama'])) {
            $data['gambar_utama'] = $this->uploadImage($data['gambar_utama']);
            
            // Generate thumbnail (optional)
            if ($data['gambar_utama']) {
                $this->generateThumbnail($data['gambar_utama']);
            }
        }

        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        $berita = $this->beritaRepository->create($data);

        // Clear cache when new berita is created
        Cache::forget('home.latest_berita');
        Cache::forget('berita.published');
        Cache::forget('home.seo_data');

        return $berita;
    }

    public function updateBerita($id, array $data)
    {
        $berita = $this->beritaRepository->find($id);

        // Sanitize HTML content
        if (isset($data['konten'])) {
            $data['konten'] = $this->htmlSanitizer->sanitize($data['konten']);
        }
        if (isset($data['ringkasan'])) {
            $data['ringkasan'] = $this->htmlSanitizer->sanitize($data['ringkasan']);
        }

        // Handle remove image checkbox
        if (isset($data['remove_image']) && $data['remove_image']) {
            if ($berita->gambar_utama) {
                Storage::disk('public')->delete($berita->gambar_utama);
            }
            $data['gambar_utama'] = null;
            unset($data['remove_image']);
        }
        // Handle new image upload (check if it's a file object, not null/string)
        elseif (isset($data['gambar_utama']) && is_object($data['gambar_utama'])) {
            // Delete old image
            if ($berita->gambar_utama) {
                $this->imageUploadService->delete($berita->gambar_utama);
                
                // Delete old thumbnail if exists
                $oldThumbnail = 'thumbnails/berita/' . pathinfo($berita->gambar_utama, PATHINFO_FILENAME) . '_thumb.' . pathinfo($berita->gambar_utama, PATHINFO_EXTENSION);
                $this->imageUploadService->delete($oldThumbnail);
            }
            
            $data['gambar_utama'] = $this->uploadImage($data['gambar_utama']);
            
            // Generate new thumbnail
            if ($data['gambar_utama']) {
                $this->generateThumbnail($data['gambar_utama']);
            }
        } else {
            // Keep existing image if no new upload - REMOVE from data array
            unset($data['gambar_utama']);
        }

        // Remove remove_image field if exists
        if (isset($data['remove_image'])) {
            unset($data['remove_image']);
        }

        if (isset($data['status']) && $data['status'] === 'published' && !$berita->published_at) {
            $data['published_at'] = now();
        }

        $updatedBerita = $this->beritaRepository->update($id, $data);

        // Clear cache when berita is updated
        Cache::forget('home.latest_berita');
        Cache::forget('berita.published');
        Cache::forget('berita.' . $id);
        Cache::forget('home.seo_data');

        return $updatedBerita;
    }

    public function deleteBerita($id)
    {
        $berita = $this->beritaRepository->find($id);
        
        // Delete image if exists
        if ($berita->gambar_utama) {
            $this->imageUploadService->delete($berita->gambar_utama);
            
            // Delete thumbnail if exists
            $thumbnailPath = 'thumbnails/berita/' . pathinfo($berita->gambar_utama, PATHINFO_FILENAME) . '_thumb.' . pathinfo($berita->gambar_utama, PATHINFO_EXTENSION);
            $this->imageUploadService->delete($thumbnailPath);
        }

        $deleted = $this->beritaRepository->delete($id);

        // Clear cache when berita is deleted
        Cache::forget('home.latest_berita');
        Cache::forget('berita.published');
        Cache::forget('berita.' . $id);
        Cache::forget('home.seo_data');

        return $deleted;
    }

    public function getLatestBerita($limit = 5)
    {
        return $this->beritaRepository->getLatest($limit);
    }

    /**
     * Search berita by title or content
     */
    public function searchBerita($keyword, $perPage = 12)
    {
        return $this->beritaRepository->search($keyword, $perPage);
    }
    
    /**
     * Advanced search with multiple filters
     */
    public function searchWithFilters(array $filters, $perPage = 12)
    {
        return $this->beritaRepository->advancedSearch($filters, $perPage);
    }
    
    /**
     * Get search suggestions for autocomplete
     */
    public function getSearchSuggestions($query, $limit = 5)
    {
        return $this->beritaRepository->getSearchSuggestions($query, $limit);
    }

    /**
     * Upload image menggunakan ImageUploadService
     * dengan resize dan optimization
     */
    protected function uploadImage($image)
    {
        // Gunakan ImageUploadService untuk resize & optimize
        $path = $this->imageUploadService->upload(
            $image,
            'berita',      // folder
            1200,          // max width
            null           // max height (auto aspect ratio)
        );
        
        return $path;
    }

    /**
     * Generate thumbnail dari image path
     * Thumbnail disimpan di folder thumbnails/berita
     */
    protected function generateThumbnail($imagePath)
    {
        try {
            // Generate thumbnail using ImageUploadService
            $thumbnailPath = $this->imageUploadService->createThumbnailFromPath(
                $imagePath,
                'thumbnails/berita',  // folder
                400,                   // width
                300                    // height
            );
            
            return $thumbnailPath;
        } catch (\Exception $e) {
            Log::error('Thumbnail generation failed: ' . $e->getMessage());
            return null;
        }
    }
}