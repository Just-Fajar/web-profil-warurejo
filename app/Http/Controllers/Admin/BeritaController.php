<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Services\BeritaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index()
    {
        $berita = $this->beritaService->getPaginatedBerita(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(BeritaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['admin_id'] = auth()->guard('admin')->id();

            $this->beritaService->createBerita($data);

            // Clear cache
            Cache::forget('home.latest_berita');
            Cache::forget('profil_desa');

            return redirect()
                ->route('admin.berita.index')
                ->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $berita = $this->beritaService->getBeritaById($id);
        return view('admin.berita.show', compact('berita'));
    }

    public function edit($id)
    {
        $berita = $this->beritaService->getBeritaById($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(BeritaRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->beritaService->updateBerita($id, $data);

            // Clear cache
            Cache::forget('home.latest_berita');
            Cache::forget('profil_desa');

            return redirect()
                ->route('admin.berita.index')
                ->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->beritaService->deleteBerita($id);

            // Clear cache
            Cache::forget('home.latest_berita');
            Cache::forget('profil_desa');

            return redirect()
                ->route('admin.berita.index')
                ->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete berita
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada berita yang dipilih.'
                ], 400);
            }

            $count = 0;
            foreach ($ids as $id) {
                $this->beritaService->deleteBerita($id);
                $count++;
            }

            // Clear cache
            Cache::forget('home.latest_berita');
            Cache::forget('profil_desa');

            return response()->json([
                'success' => true,
                'message' => "{$count} berita berhasil dihapus."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }} 
