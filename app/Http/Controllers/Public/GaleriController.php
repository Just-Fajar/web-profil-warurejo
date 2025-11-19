<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Repositories\GaleriRepository;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    protected $galeriRepository;

    public function __construct(GaleriRepository $galeriRepository)
    {
        $this->galeriRepository = $galeriRepository;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        
        // Build query
        if ($search || $kategori) {
            $query = Galeri::with('admin')->published()->latest();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }
            
            if ($kategori) {
                $query->byKategori($kategori);
            }
            
            $galeris = $query->paginate(24)->appends($request->query());
        } else {
            // Use published scope instead of active
            $galeris = Galeri::with('admin')->published()->latest()->paginate(24);
        }
        
        // SEO Data
        $title = 'Galeri Dokumentasi';
        if ($kategori) {
            $title .= " - " . ucfirst($kategori);
        }
        
        $seoData = SEOHelper::generateMetaTags([
            'title' => $title . ' - Desa Warurejo',
            'description' => 'Galeri foto dan video kegiatan, program, dan momen penting Desa Warurejo.',
            'keywords' => 'galeri desa warurejo, foto kegiatan desa, video desa',
            'type' => 'website'
        ]);
        
        return view('public.galeri.index', compact('galeris', 'search', 'kategori', 'seoData'));
    }
}
