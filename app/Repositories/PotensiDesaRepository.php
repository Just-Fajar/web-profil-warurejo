<?php

namespace App\Repositories;

use App\Models\PotensiDesa;

class PotensiDesaRepository extends BaseRepository
{
    public function __construct(PotensiDesa $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active potensi
     */
    public function getActive()
    {
        return $this->model
            ->active()
            ->latest()
            ->paginate(12);
    }

    /**
     * Get potensi by kategori
     */
    public function getByKategori($kategori)
    {
        return $this->model
            ->active()
            ->byKategori($kategori)
            ->latest()
            ->paginate(12);
    }

    /**
     * Find potensi by slug
     */
    public function findBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
    }

    /**
     * Get related potensi (same category)
     */
    public function getRelated($potensi, $limit = 3)
    {
        return $this->model
            ->active()
            ->where('id', '!=', $potensi->id)
            ->where('kategori', $potensi->kategori)
            ->ordered()
            ->limit($limit)
            ->get();
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
     * Reorder potensi
     */
    public function reorder(array $order)
    {
        foreach ($order as $position => $id) {
            $this->model
                ->where('id', $id)
                ->update(['urutan' => $position + 1]);
        }
        
        return true;
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $potensi = $this->find($id);
        $potensi->is_active = !$potensi->is_active;
        $potensi->save();
        
        return $potensi;
    }

    /**
     * Get featured potensi (first N items)
     */
    public function getFeatured($limit = 6)
    {
        return $this->model
            ->active()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Search potensi by name or description
     */
    public function search($keyword)
    {
        return $this->model
            ->active()
            ->where(function($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->ordered()
            ->get();
    }
    
    /**
     * Search with filters (search, kategori, sorting)
     */
    public function searchWithFilters(array $filters)
    {
        $query = $this->model->active();
        
        // Search by keyword
        if (!empty($filters['search'])) {
            $keyword = $filters['search'];
            $query->where(function($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }
        
        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $query->byKategori($filters['kategori']);
        }
        
        // Sort by
        $sortBy = $filters['urutkan'] ?? 'terbaru';
        switch ($sortBy) {
            case 'terpopuler':
                $query->orderBy('views', 'desc');
                break;
            case 'terlama':
                $query->oldest();
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }
        
        return $query->paginate(12);
    }
}
