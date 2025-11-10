<?php

namespace App\Repositories;

use App\Models\Galeri;

class GaleriRepository extends BaseRepository
{
    public function __construct(Galeri $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active galeri with pagination
     */
    public function getActive($perPage = 24)
    {
        return $this->model
            ->active()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get latest galeri
     */
    public function getLatest($limit = 6)
    {
        return $this->model
            ->active()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get galeri by kategori
     */
    public function getByKategori($kategori, $perPage = 24)
    {
        return $this->model
            ->active()
            ->byKategori($kategori)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all categories with count
     */
    public function getCategoriesWithCount()
    {
        return $this->model
            ->active()
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->get();
    }

    /**
     * Get galeri by admin
     */
    public function getByAdmin($adminId, $perPage = 15)
    {
        return $this->model
            ->where('admin_id', $adminId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get galeri by date range
     */
    public function getByDateRange($startDate, $endDate, $perPage = 24)
    {
        return $this->model
            ->active()
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get recent galeri by date
     */
    public function getRecent($limit = 12)
    {
        return $this->model
            ->active()
            ->whereNotNull('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $galeri = $this->find($id);
        $galeri->is_active = !$galeri->is_active;
        $galeri->save();
        
        return $galeri;
    }
}
