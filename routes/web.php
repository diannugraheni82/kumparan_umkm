<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\VerifikasiUmkmController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Fitur Verifikasi UMKM
    Route::get('/verifikasi', [VerifikasiUmkmController::class, 'index'])->name('verifikasi.index');    
    Route::post('/verifikasi/{id}', [VerifikasiUmkmController::class, 'updateStatus'])->name('verifikasi.update');
    Route::get('/verifikasi/cetak', [VerifikasiUmkmController::class, 'cetakPdf'])->name('verifikasi.cetak');
});

/*
|--------------------------------------------------------------------------
| UMKM ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
    
    // Data & Portofolio
    Route::get('/input-data', [UmkmController::class, 'create'])->name('input');
    Route::post('/input-data', [UmkmController::class, 'store'])->name('store');
    Route::get('/edit-data', [UmkmController::class, 'edit'])->name('edit');
    Route::patch('/edit-data', [UmkmController::class, 'update'])->name('update');
    Route::get('/portofolio', function () {
        return view('umkm.portofolio');
    })->name('portofolio');

    // Finansial (Pinjaman/Paylater)
    Route::post('/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])->name('ajukan-pinjaman');
    Route::get('/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])->name('cetak-bukti');
    Route::get('/bayar/{id_pinjaman}', [UmkmController::class, 'bayar'])->name('bayar');
});

/*
|--------------------------------------------------------------------------
| MITRA ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    // Dashboard Utama Mitra
    Route::get('/dashboard', [MitraController::class, 'dashboard'])->name('dashboard');
    
    // Eksplorasi & Detail UMKM
    Route::get('/eksplorasi', [MitraController::class, 'eksplorasi'])->name('eksplorasi');
    Route::get('/umkm/{id}', [MitraController::class, 'show'])->name('umkm.show');

    // Manajemen Event
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
    });
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

require __DIR__.'/auth.php';