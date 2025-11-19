<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Http\Requests\GaleriRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
class GaleriController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeri = Galeri::with('admin')->latest()->get(); // Eager load admin to prevent N+1
        return view('admin.galeri.index', compact('galeri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GaleriRequest $request)
    {
        try {
            $data = $request->validated();
            $data['admin_id'] = auth('admin')->id();
            
            // Handle image upload
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $this->imageUploadService->upload(
                    $request->file('gambar'), 
                    'galeri'
                );
            }
            
            Galeri::create($data);
            
            // Clear cache
            Cache::forget('home.galeri');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk upload multiple images
     */
    protected function bulkUpload(Request $request)
    {
        try {
            $files = $request->file('files');
            $kategori = $request->input('kategori', 'kegiatan');
            $tanggal = $request->input('tanggal', now());
            $is_active = $request->input('is_active', 1);
            $uploadedCount = 0;

            foreach ($files as $file) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                
                $filePath = $this->imageUploadService->upload($file, 'galeri');
                
                Galeri::create([
                    'admin_id' => auth('admin')->id(),
                    'judul' => $fileName,
                    'gambar' => $filePath,
                    'kategori' => $kategori,
                    'deskripsi' => '',
                    'tanggal' => $tanggal,
                    'is_active' => $is_active,
                ]);
                
                $uploadedCount++;
            }
            
            // Clear cache
            Cache::forget('home.galeri');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.galeri.index')
                ->with('success', $uploadedCount . ' foto berhasil diunggah!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat bulk upload: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GaleriRequest $request, Galeri $galeri)
    {
        try {
            $data = $request->validated();
            
            // Handle image update
            if ($request->hasFile('gambar')) {
                // Delete old image
                if ($galeri->gambar) {
                    $this->imageUploadService->delete($galeri->gambar);
                }
                
                // Upload new image
                $data['gambar'] = $this->imageUploadService->upload(
                    $request->file('gambar'), 
                    'galeri'
                );
            }
            
            $galeri->update($data);
            
            // Clear cache
            Cache::forget('home.galeri');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        try {
            // Delete image
            if ($galeri->gambar) {
                $this->imageUploadService->delete($galeri->gambar);
            }
            
            $galeri->delete();
            
            // Clear cache
            Cache::forget('home.galeri');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete galeri
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada galeri yang dipilih'
                ], 400);
            }
            
            $galeriList = Galeri::whereIn('id', $ids)->get();
            
            // Delete image files
            foreach ($galeriList as $galeri) {
                if ($galeri->gambar) {
                    $this->imageUploadService->delete($galeri->gambar);
                }
            }
            
            // Delete records
            Galeri::whereIn('id', $ids)->delete();
            
            // Clear cache
            Cache::forget('home.galeri');
            Cache::forget('profil_desa');
            
            return response()->json([
                'success' => true,
                'message' => count($ids) . ' galeri berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
