<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::getInstance();
        return view('public.profil.index', compact('profil'));
    }

    public function visiMisi()
    {
        $profil = ProfilDesa::getInstance();
        return view('public.profil.visi-misi', compact('profil'));
    }

    public function sejarah()
    {
        $profil = ProfilDesa::getInstance();
        return view('public.profil.sejarah', compact('profil'));
    }

    public function strukturOrganisasi()
    {
        $profil = ProfilDesa::getInstance();
        return view('public.profil.struktur-organisasi', compact('profil'));
    }
}
