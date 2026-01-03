<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VerifikasiUmkmController;
use App\Http\Controllers\UmkmController; // Pastikan ini ada
use App\Http\Controllers\ProfileController; // Pastikan ini ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Redirect Utama
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (Multi-Role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'mitra' => redirect()->route('mitra.dashboard'),
        'umkm'  => redirect()->route('umkm.dashboard'),
        default => abort(403, 'Role tidak dikenali'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Gabungan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Fitur Verifikasi UMKM (Dari Teman Anda)
    Route::get('/admin/verifikasi', [VerifikasiUmkmController::class, 'index'])->name('admin.verifikasi.index');    
    Route::post('/admin/verifikasi/{id}', [VerifikasiUmkmController::class, 'updateStatus'])->name('admin.verifikasi.update');
    Route::get('/admin/verifikasi/cetak', [VerifikasiUmkmController::class, 'cetakPdf'])->name('admin.verifikasi.cetak');
});

/*
|--------------------------------------------------------------------------
| UMKM ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->group(function () {
    // Dashboard UMKM
    Route::get('/umkm/dashboard', [UmkmController::class, 'index'])->name('umkm.dashboard');

    // Portofolio & Data
    Route::get('/umkm/portofolio', function () {
        return view('umkm.portofolio');
    })->name('umkm.portofolio');

    Route::get('/umkm/input-data', [UmkmController::class, 'create'])->name('umkm.input');
    Route::post('/umkm/input-data', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/edit-data', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::patch('/umkm/edit-data', [UmkmController::class, 'update'])->name('umkm.update');

    // Paylater / Pinjaman
    Route::post('/umkm/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])->name('umkm.ajukan-pinjaman');
    Route::get('/umkm/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])->name('umkm.cetak-bukti');
    Route::get('/umkm/bayar/{id_pinjaman}', [UmkmController::class, 'bayar'])->name('umkm.bayar');
});

/*
|--------------------------------------------------------------------------
| MITRA ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/dashboard', function () {
        return view('mitra.dashboard');
    })->name('mitra.dashboard');
});

/*
|--------------------------------------------------------------------------
| PROFILE & AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Menggunakan sistem auth bawaan Laravel (Laravel Breeze/Jetstream)
require __DIR__ . '/auth.php';