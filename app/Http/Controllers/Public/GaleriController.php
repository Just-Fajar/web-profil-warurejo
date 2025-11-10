<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Repositories\GaleriRepository;
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
        $kategori = $request->get('kategori');
        
        if ($kategori) {
            $galeri = $this->galeriRepository->getByKategori($kategori, 24);
        } else {
            $galeri = $this->galeriRepository->getActive(24);
        }
        
        return view('public.galeri.index', compact('galeri', 'kategori'));
    }
}
