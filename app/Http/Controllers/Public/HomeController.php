<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use App\Services\BeritaService;
use App\Services\PotensiDesaService;
use App\Repositories\GaleriRepository;

class HomeController extends Controller
{
    protected $beritaService;
    protected $potensiService;
    protected $galeriRepository;

    public function __construct(
        BeritaService $beritaService,
        PotensiDesaService $potensiService,
        GaleriRepository $galeriRepository
    ) {
        $this->beritaService = $beritaService;
        $this->potensiService = $potensiService;
        $this->galeriRepository = $galeriRepository;
    }

    public function index()
    {
        // Ambil profil desa tunggal
        $profil = ProfilDesa::first() ?? new ProfilDesa([
            'nama_desa' => 'Desa Warurejo',
            'kecamatan' => 'Balerejo',
            'kabupaten' => 'Madiun',
            'provinsi' => 'Jawa Timur',
            'jumlah_penduduk' => 0,
            'luas_wilayah' => 0
        ]);

        // Ambil data berita terbaru
        $latest_berita = $this->beritaService->getLatestBerita(3);

        // Ambil data potensi aktif
        $potensi = $this->potensiService->getActivePotensi();

        // Ambil galeri terbaru
        $galeri = $this->galeriRepository->getLatest(6);

        // Kirim data ke view
        return view('public.home', compact(
            'profil',
            'latest_berita',
            'potensi',
            'galeri'
        ));
    }
}
