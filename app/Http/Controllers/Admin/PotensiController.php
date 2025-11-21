<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PotensiDesa;
use App\Http\Requests\PotensiRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PotensiController extends Controller
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
        $potensi = PotensiDesa::latest()->get();
        return view('admin.potensi.index', compact('potensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.potensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PotensiRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Auto-generate slug
            $data['slug'] = Str::slug($data['nama']);
            
            // Handle is_active checkbox (default true if not exists)
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            
            // Handle image upload
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $this->imageUploadService->upload(
                    $request->file('gambar'), 
                    'potensi'
                );
            }
            
            PotensiDesa::create($data);
            
            // Clear cache
            Cache::forget('home.potensi');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.potensi.index')
                ->with('success', 'Potensi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PotensiDesa $potensi)
    {
        return view('admin.potensi.show', compact('potensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PotensiDesa $potensi)
    {
        return view('admin.potensi.edit', compact('potensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PotensiRequest $request, PotensiDesa $potensi)
    {
        try {
            $data = $request->validated();
            
            // Handle is_active checkbox
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            
            // Update slug if nama changed
            if ($data['nama'] !== $potensi->nama) {
                $data['slug'] = Str::slug($data['nama']);
            }
            
            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image
                if ($potensi->gambar) {
                    $this->imageUploadService->delete($potensi->gambar);
                }
                
                // Upload new image
                $data['gambar'] = $this->imageUploadService->upload(
                    $request->file('gambar'), 
                    'potensi'
                );
            }
            
            $potensi->update($data);
            
            // Clear cache
            Cache::forget('home.potensi');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.potensi.index')
                ->with('success', 'Potensi berhasil diperbarui!');
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
    public function destroy(PotensiDesa $potensi)
    {
        try {
            // Delete image
            if ($potensi->gambar) {
                $this->imageUploadService->delete($potensi->gambar);
            }
            
            $potensi->delete();
            
            // Clear cache
            Cache::forget('home.potensi');
            Cache::forget('profil_desa');
            
            return redirect()
                ->route('admin.potensi.index')
                ->with('success', 'Potensi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete potensi
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada potensi yang dipilih'
                ], 400);
            }
            
            $potensiList = PotensiDesa::whereIn('id', $ids)->get();
            
            // Delete images
            foreach ($potensiList as $potensi) {
                if ($potensi->gambar) {
                    $this->imageUploadService->delete($potensi->gambar);
                }
            }
            
            // Delete records
            PotensiDesa::whereIn('id', $ids)->delete();
            
            // Clear cache
            Cache::forget('home.potensi');
            Cache::forget('profil_desa');
            
            return response()->json([
                'success' => true,
                'message' => count($ids) . ' potensi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
