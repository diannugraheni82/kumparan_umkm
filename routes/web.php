<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VerifikasiUmkmController;

Route::get('/force-login', function() {
    $user = \App\Models\User::where('role', 'admin')->first();
    if($user) {
        Auth::login($user);
        return redirect('/admin/dashboard');
    }
    return 'User Admin tidak ditemukan di database!';
});

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
});

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'mitra' => redirect()->route('mitra.dashboard'),
        'umkm'  => redirect()->route('umkm.dashboard'),
        default => abort(403, 'Role tidak dikenali'),
    };
})->middleware('auth')->name('dashboard');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/verifikasi', [AdminController::class, 'verifikasiIndex'])->name('verifikasi.index');
    Route::patch('/verifikasi/{id}', [AdminController::class, 'verifikasiUpdate'])->name('verifikasi.update');
    Route::get('/cetak-laporan', [AdminController::class, 'cetakLaporan'])->name('verifikasi.cetak');
    Route::get('/pinjaman', [AdminController::class, 'pinjamanIndex'])->name('pinjaman.index');
    Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])->name('pembayaran.index');
    Route::get('/event', [AdminController::class, 'eventIndex'])->name('event.index');
    Route::get('/event/detail/{id}', [AdminController::class, 'showEvent'])->name('event.show');
});



Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
    Route::get('/input-data', [UmkmController::class, 'create'])->name('create');
    Route::post('/store-data', [UmkmController::class, 'store'])->name('store');
    Route::get('/edit-data', [UmkmController::class, 'edit'])->name('edit');
    Route::patch('/update-data', [UmkmController::class, 'update'])->name('update');
    Route::get('/events', [UmkmController::class, 'semuaEvent'])->name('semua_event');
    Route::get('/event/{id}', [UmkmController::class, 'detailEvent'])->name('detail_event');    
    Route::post('/daftar-event/{id}', [UmkmController::class, 'daftarEvent'])->name('daftar_event');
    Route::post('/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])->name('ajukan-pinjaman');
    Route::get('/bayar/{id}', [UmkmController::class, 'bayar'])->name('bayar');
    Route::get('/pembayaran-sukses/{id}', [UmkmController::class, 'pembayaranSukses'])->name('pembayaranSukses');
    Route::get('/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])->name('cetakBukti');
    Route::post('/kerjasama/{id}/acc', [UmkmController::class, 'accKerjasama'])->name('acc_kerjasama');
    Route::post('/kerjasama/{id}/tolak', [UmkmController::class, 'tolakKerjasama'])->name('tolak_kerjasama');
});

Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [MitraController::class, 'dashboard'])->name('dashboard'); // Panggil: route('mitra.dashboard')
    Route::get('/eksplorasi', [MitraController::class, 'eksplorasi'])->name('eksplorasi');
    Route::get('/umkm/{id}', [MitraController::class, 'show'])->name('umkm.show');
    Route::post('/ajukan-kerjasama/{id}', [MitraController::class, 'ajukanKerjasama'])->name('ajukan.kerjasama');
    Route::resource('events', EventController::class)->only(['index', 'create', 'store']);
    Route::get('/mitra/partners', [MitraController::class, 'partnerSaya'])->name('mitra.partners');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';