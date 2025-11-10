<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Services\BeritaService;
use Illuminate\Http\Request;

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

            return redirect()
                ->route('admin.berita.index')
                ->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}