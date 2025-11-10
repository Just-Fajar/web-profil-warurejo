<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\PotensiController;
use App\Http\Controllers\Public\GaleriController;
use App\Http\Controllers\Public\KontakController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('/struktur-organisasi', [ProfilController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
});

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [BeritaController::class, 'show'])->name('show');
});

Route::prefix('potensi')->name('potensi.')->group(function () {
    Route::get('/', [PotensiController::class, 'index'])->name('index');
    Route::get('/{slug}', [PotensiController::class, 'show'])->name('show');
});

Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
});

Route::prefix('kontak')->name('kontak.')->group(function () {
    Route::get('/', [KontakController::class, 'index'])->name('index');
    Route::post('/send', [KontakController::class, 'send'])->name('send');
});

// Peta Desa
Route::get('/peta-desa', function () {
    return view('public.peta-desa');
})->name('peta-desa');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Routes (Not Authenticated)
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Authenticated Routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Berita Management
        Route::resource('berita', AdminBeritaController::class);
    });
});