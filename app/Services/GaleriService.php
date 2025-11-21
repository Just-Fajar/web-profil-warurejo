<?php

namespace App\Services;

use App\Repositories\GaleriRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GaleriService
{
    protected $galeriRepository;

    public function __construct(GaleriRepository $galeriRepository)
    {
        $this->galeriRepository = $galeriRepository;
    }

    public function getAllGaleri()
    {
        return $this->galeriRepository->all();
    }

    public function getPaginatedGaleri($perPage = 15)
    {
        return $this->galeriRepository->paginate($perPage);
    }

    public function getActiveGaleri($perPage = 24)
    {
        return $this->galeriRepository->getActive($perPage);
    }

    public function getLatestGaleri($limit = 6)
    {
        return $this->galeriRepository->getLatest($limit);
    }

    public function getGaleriByKategori($kategori, $perPage = 24)
    {
        return $this->galeriRepository->getByKategori($kategori, $perPage);
    }

    public function getGaleriById($id)
    {
        return $this->galeriRepository->find($id);
    }

    public function getCategoriesWithCount()
    {
        return $this->galeriRepository->getCategoriesWithCount();
    }

    public function createGaleri(array $data)
    {
        if (isset($data['gambar'])) {
            $data['gambar'] = $this->uploadImage($data['gambar']);
        }

        if (!isset($data['admin_id'])) {
            $data['admin_id'] = auth()->guard('admin')->id();
        }

        if (empty($data['tanggal'])) {
            $data['tanggal'] = now();
        }

        $galeri = $this->galeriRepository->create($data);

        // Clear cache when new galeri is created
        Cache::forget('home.galeri');

        return $galeri;
    }

    public function updateGaleri($id, array $data)
    {
        $galeri = $this->galeriRepository->find($id);

        // Handle new image upload (check if it's a file object, not null/string)
        if (isset($data['gambar']) && is_object($data['gambar'])) {
            // Delete old image
            if ($galeri->gambar) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $data['gambar'] = $this->uploadImage($data['gambar']);
        } else {
            // Keep existing image if no new upload - REMOVE from data array
            unset($data['gambar']);
        }

        $updated = $this->galeriRepository->update($id, $data);

        // Clear cache when galeri is updated
        Cache::forget('home.galeri');

        return $updated;
    }

    public function deleteGaleri($id)
    {
        $galeri = $this->galeriRepository->find($id);
        
        // Delete image if exists
        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $deleted = $this->galeriRepository->delete($id);

        // Clear cache when galeri is deleted
        Cache::forget('home.galeri');

        return $deleted;
    }

    public function toggleActive($id)
    {
        return $this->galeriRepository->toggleActive($id);
    }

    public function getByDateRange($startDate, $endDate, $perPage = 24)
    {
        return $this->galeriRepository->getByDateRange($startDate, $endDate, $perPage);
    }

    public function getRecentGaleri($limit = 12)
    {
        return $this->galeriRepository->getRecent($limit);
    }

    protected function uploadImage($image)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('galeri', $filename, 'public');
        return $path;
    }
}
