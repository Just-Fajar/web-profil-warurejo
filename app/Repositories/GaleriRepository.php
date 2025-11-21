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
            ->with('admin') // Eager load admin to prevent N+1
            ->published()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get latest galeri
     */
    public function getLatest($limit = 6)
    {
        return $this->model
            ->with('admin') // Eager load admin to prevent N+1
            ->published()
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
            ->with('admin') // Eager load admin to prevent N+1
            ->published()
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
            ->published()
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
            ->with('admin') // Eager load admin to prevent N+1
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
            ->with('admin') // Eager load admin to prevent N+1
            ->published()
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
            ->with('admin') // Eager load admin to prevent N+1
            ->published()
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
