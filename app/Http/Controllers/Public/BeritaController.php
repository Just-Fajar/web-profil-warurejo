<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\BeritaService;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index(Request $request)
    {
        $perPage = 12;
        $berita = $this->beritaService->getPublishedBerita($perPage);
        
        return view('public.berita.index', compact('berita'));
    }

    public function show($slug)
    {
        try {
            $berita = $this->beritaService->getBeritaBySlug($slug);
            
            // Get related berita (same category or recent)
            $relatedBerita = $this->beritaService->getLatestBerita(4);
            
            return view('public.berita.show', compact('berita', 'relatedBerita'));
        } catch (\Exception $e) {
            abort(404, 'Berita tidak ditemukan');
        }
    }
}
