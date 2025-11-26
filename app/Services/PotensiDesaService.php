<?php

namespace App\Services;

use App\Repositories\PotensiDesaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PotensiDesaService
{
    protected $potensiRepository;

    public function __construct(PotensiDesaRepository $potensiRepository)
    {
        $this->potensiRepository = $potensiRepository;
    }

    public function getAllPotensi()
    {
        return $this->potensiRepository->all();
    }

    public function getActivePotensi()
    {
        return $this->potensiRepository->getActive();
    }

    public function getPotensiByKategori($kategori)
    {
        return $this->potensiRepository->getByKategori($kategori);
    }

    public function getPotensiById($id)
    {
        return $this->potensiRepository->find($id);
    }

    public function getPotensiBySlug($slug)
    {
        return $this->potensiRepository->findBySlug($slug);
    }

    public function getRelatedPotensi($potensi, $limit = 3)
    {
        return $this->potensiRepository->getRelated($potensi, $limit);
    }

    public function getFeaturedPotensi($limit = 6)
    {
        return $this->potensiRepository->getFeatured($limit);
    }

    public function getCategoriesWithCount()
    {
        return $this->potensiRepository->getCategoriesWithCount();
    }

    public function createPotensi(array $data)
    {
        if (isset($data['gambar'])) {
            $data['gambar'] = $this->uploadImage($data['gambar']);
        }

        // Auto generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $potensi = $this->potensiRepository->create($data);

        // Clear cache when new potensi is created
        Cache::forget('home.potensi');

        return $potensi;
    }

    public function updatePotensi($id, array $data)
    {
        $potensi = $this->potensiRepository->find($id);

        // Handle new image upload (check if it's a file object, not null/string)
        if (isset($data['gambar']) && is_object($data['gambar'])) {
            // Delete old image
            if ($potensi->gambar) {
                Storage::disk('public')->delete($potensi->gambar);
            }
            $data['gambar'] = $this->uploadImage($data['gambar']);
        } else {
            // Keep existing image if no new upload - REMOVE from data array
            unset($data['gambar']);
        }

        // Update slug if nama changed
        if (isset($data['nama']) && $data['nama'] !== $potensi->nama) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $updated = $this->potensiRepository->update($id, $data);

        // Clear cache when potensi is updated
        Cache::forget('home.potensi');

        return $updated;
    }

    public function deletePotensi($id)
    {
        $potensi = $this->potensiRepository->find($id);
        
        // Delete image if exists
        if ($potensi->gambar) {
            Storage::disk('public')->delete($potensi->gambar);
        }

        $deleted = $this->potensiRepository->delete($id);

        // Clear cache when potensi is deleted
        Cache::forget('home.potensi');

        return $deleted;
    }

    public function toggleActive($id)
    {
        return $this->potensiRepository->toggleActive($id);
    }

    public function reorderPotensi(array $order)
    {
        return $this->potensiRepository->reorder($order);
    }

    /**
     * Search potensi by name or description
     */
    public function searchPotensi($keyword)
    {
        return $this->potensiRepository->search($keyword);
    }
    
    /**
     * Search with filters (search, kategori, sorting)
     */
    public function searchWithFilters(array $filters)
    {
        return $this->potensiRepository->searchWithFilters($filters);
    }

    protected function uploadImage($image)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('potensi', $filename, 'public');
        return $path;
    }
}
