<?php

namespace App\Services;

use App\Repositories\BeritaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaService
{
    protected $beritaRepository;

    public function __construct(BeritaRepository $beritaRepository)
    {
        $this->beritaRepository = $beritaRepository;
    }

    public function getAllBerita()
    {
        return $this->beritaRepository->all();
    }

    public function getPaginatedBerita($perPage = 15)
    {
        return $this->beritaRepository->paginate($perPage);
    }

    public function getPublishedBerita($perPage = 10)
    {
        return $this->beritaRepository->getPublished($perPage);
    }

    public function getBeritaById($id)
    {
        return $this->beritaRepository->find($id);
    }

    public function getBeritaBySlug($slug)
    {
        $berita = $this->beritaRepository->findBySlug($slug);
        $this->beritaRepository->incrementViews($berita->id);
        return $berita;
    }

    public function createBerita(array $data)
    {
        if (isset($data['gambar_utama'])) {
            $data['gambar_utama'] = $this->uploadImage($data['gambar_utama']);
        }

        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->beritaRepository->create($data);
    }

    public function updateBerita($id, array $data)
    {
        $berita = $this->beritaRepository->find($id);

        if (isset($data['gambar_utama'])) {
            // Delete old image
            if ($berita->gambar_utama) {
                Storage::disk('public')->delete($berita->gambar_utama);
            }
            $data['gambar_utama'] = $this->uploadImage($data['gambar_utama']);
        }

        if ($data['status'] === 'published' && !$berita->published_at) {
            $data['published_at'] = now();
        }

        return $this->beritaRepository->update($id, $data);
    }

    public function deleteBerita($id)
    {
        $berita = $this->beritaRepository->find($id);
        
        // Delete image if exists
        if ($berita->gambar_utama) {
            Storage::disk('public')->delete($berita->gambar_utama);
        }

        return $this->beritaRepository->delete($id);
    }

    public function getLatestBerita($limit = 5)
    {
        return $this->beritaRepository->getLatest($limit);
    }

    protected function uploadImage($image)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('berita', $filename, 'public');
        return $path;
    }
}