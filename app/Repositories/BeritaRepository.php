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
            ->with('admin') // Eager load admin to prevent N+1
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
            ->with('admin') // Eager load admin to prevent N+1
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
            ->with('admin') // Eager load admin to prevent N+1
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
        $query = $this->model
            ->with('admin') // Eager load admin to prevent N+1
            ->where('status', $status);
        
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
            ->with('admin') // Eager load admin to prevent N+1
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
            ->with('admin') // Eager load admin to prevent N+1
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
            ->with('admin') // Eager load admin to prevent N+1
            ->where('admin_id', $adminId)
            ->latest()
            ->paginate($perPage);
    }
    
    /**
     * Advanced search with multiple filters
     */
    public function advancedSearch(array $filters, $perPage = 12)
    {
        $query = $this->model->with('admin')->published();
        
        // Search by keyword
        if (!empty($filters['search'])) {
            $keyword = $filters['search'];
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('ringkasan', 'like', "%{$keyword}%")
                  ->orWhere('konten', 'like', "%{$keyword}%");
            });
        }
        
        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('published_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->whereDate('published_at', '<=', $filters['date_to']);
        }
        
        // Sort by
        $sortBy = $filters['sort'] ?? 'latest';
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
        
        return $query->paginate($perPage);
    }
    
    /**
     * Get search suggestions for autocomplete
     */
    public function getSearchSuggestions($query, $limit = 5)
    {
        return $this->model
            ->published()
            ->where('judul', 'like', "%{$query}%")
            ->select('judul', 'slug')
            ->limit($limit)
            ->get()
            ->map(function($berita) {
                return [
                    'title' => $berita->judul,
                    'url' => route('berita.show', $berita->slug)
                ];
            });
    }
}
