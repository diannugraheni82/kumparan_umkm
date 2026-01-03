<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return view('welcome');
});

// --- ROLE REDIRECTOR ---
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'mitra') {
        return redirect()->route('mitra.dashboard');
    }
    return redirect()->route('umkm.dashboard');
})->middleware(['auth'])->name('dashboard');

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// --- UMKM ROUTES ---
Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
    Route::get('/input-data', [UmkmController::class, 'create'])->name('input');
    Route::post('/input-data', [UmkmController::class, 'store'])->name('store');
    Route::get('/edit-data', [UmkmController::class, 'edit'])->name('edit');
    Route::patch('/edit-data', [UmkmController::class, 'update'])->name('update');
    Route::post('/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])->name('ajukan-pinjaman');
    Route::get('/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])->name('cetak-bukti');
    Route::get('/bayar/{id_pinjaman}', [UmkmController::class, 'bayar'])->name('bayar');
});

// --- MITRA ROUTES (INI YANG KITA PERBAIKI) ---
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    // Dashboard Utama Mitra
    Route::get('/dashboard', [MitraController::class, 'dashboard'])->name('dashboard');
    
    // Eksplorasi UMKM
    Route::get('/eksplorasi', [MitraController::class, 'eksplorasi'])->name('eksplorasi');
    
    // Detail UMKM (dari sisi Mitra)
    Route::get('/umkm/{id}', [MitraController::class, 'show'])->name('umkm.show');

    // Manajemen Event (Menggunakan EventController)
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
    });
});

// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';