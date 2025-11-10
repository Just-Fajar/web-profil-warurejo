<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\PotensiDesaService;
use Illuminate\Http\Request;

class PotensiController extends Controller
{
    protected $potensiService;

    public function __construct(PotensiDesaService $potensiService)
    {
        $this->potensiService = $potensiService;
    }

    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        
        if ($kategori) {
            $potensi = $this->potensiService->getPotensiByKategori($kategori);
        } else {
            $potensi = $this->potensiService->getActivePotensi();
        }
        
        return view('public.potensi.index', compact('potensi', 'kategori'));
    }

    public function show($slug)
    {
        try {
            $potensi = $this->potensiService->getPotensiBySlug($slug);
            
            // Get related potensi
            $relatedPotensi = $this->potensiService->getRelatedPotensi($potensi, 3);
            
            return view('public.potensi.show', compact('potensi', 'relatedPotensi'));
        } catch (\Exception $e) {
            abort(404, 'Potensi desa tidak ditemukan');
        }
    }
}
