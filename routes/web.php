<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Guest
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Redirect Dashboard by Role
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
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| UMKM
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->group(function () {

    // Dashboard UMKM
    Route::get('/umkm/dashboard', [UmkmController::class, 'index'])
        ->name('umkm.dashboard');

    // Portofolio UMKM
    Route::get('/umkm/portofolio', function () {
        return view('umkm.portofolio');
    })->name('umkm.portofolio');

    // Input Profil UMKM
    Route::get('/umkm/input-data', [UmkmController::class, 'create'])
        ->name('umkm.input');

    Route::post('/umkm/input-data', [UmkmController::class, 'store'])
        ->name('umkm.store');

    // Edit Profil UMKM
    Route::get('/umkm/edit-data', [UmkmController::class, 'edit'])
        ->name('umkm.edit');

    Route::patch('/umkm/edit-data', [UmkmController::class, 'update'])
        ->name('umkm.update');

    // Paylater / Pinjaman
    Route::post('/umkm/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])
        ->name('umkm.ajukan-pinjaman');

    Route::get('/umkm/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])
        ->name('umkm.cetak-bukti');

    Route::get('/umkm/bayar/{id_pinjaman}', [UmkmController::class, 'bayar'])
        ->name('umkm.bayar');
});

/*
|--------------------------------------------------------------------------
| MITRA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/dashboard', function () {
        return view('mitra.dashboard');
    })->name('mitra.dashboard');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
