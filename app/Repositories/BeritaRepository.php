<?php

namespace App\Repositories;

use App\Models\Berita;

class BeritaRepository extends BaseRepository
{
    public function __construct(Berita $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published berita with pagination
     */
    public function getPublished($perPage = 10)
    {
        return $this->model
            ->published()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get latest berita
     */
    public function getLatest($limit = 5)
    {
        return $this->model
            ->published()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Find berita by slug
     */
    public function findBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
    }

    /**
     * Increment views counter
     */
    public function incrementViews($id)
    {
        return $this->model
            ->where('id', $id)
            ->increment('views');
    }

    /**
     * Get berita by status
     */
    public function getByStatus($status, $perPage = 15)
    {
        $query = $this->model->where('status', $status);
        
        if ($status === 'published') {
            $query->latest();
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        return $query->paginate($perPage);
    }

    /**
     * Search berita
     */
    public function search($keyword, $perPage = 10)
    {
        return $this->model
            ->where(function($query) use ($keyword) {
                $query->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('ringkasan', 'like', "%{$keyword}%")
                    ->orWhere('konten', 'like', "%{$keyword}%");
            })
            ->published()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get popular berita by views
     */
    public function getPopular($limit = 5)
    {
        return $this->model
            ->published()
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get berita by admin
     */
    public function getByAdmin($adminId, $perPage = 15)
    {
        return $this->model
            ->where('admin_id', $adminId)
            ->latest()
            ->paginate($perPage);
    }
}
