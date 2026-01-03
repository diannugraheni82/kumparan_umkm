<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VerifikasiUmkmController;


// Tambahkan ini sementara di web.php untuk bypass login
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
});

Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
    Route::get('/input-data', [UmkmController::class, 'create'])->name('input');
    Route::post('/input-data', [UmkmController::class, 'store'])->name('store');
    Route::get('/edit-data', [UmkmController::class, 'edit'])->name('edit');
    Route::patch('/edit-data', [UmkmController::class, 'update'])->name('update'); 
    
    Route::post('/ajukan-pinjaman', [UmkmController::class, 'ajukanPinjaman'])->name('ajukan-pinjaman');
    
    // PERBAIKAN DI SINI:
    // Cukup gunakan 'cetakBukti', nanti otomatis terpanggil sebagai 'umkm.cetakBukti'
    Route::get('/cetak-bukti/{id}', [UmkmController::class, 'cetakBukti'])->name('cetakBukti');
    
    Route::get('/bayar/{id_pinjaman}', [UmkmController::class, 'bayar'])->name('bayar');
    
    // Cukup gunakan 'pembayaranSukses', nanti otomatis terpanggil sebagai 'umkm.pembayaranSukses'
    Route::get('/pembayaran-sukses/{id}', [UmkmController::class, 'pembayaranSukses'])->name('pembayaranSukses');
    
    Route::post('/umkm/kerjasama/acc/{id}', [UmkmController::class, 'accKerjasama'])->name('umkm.kerjasama.acc');
Route::post('/umkm/kerjasama/tolak/{id}', [UmkmController::class, 'tolakKerjasama'])->name('umkm.kerjasama.tolak');
});

Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [MitraController::class, 'dashboard'])->name('dashboard');
    Route::get('/eksplorasi', [MitraController::class, 'eksplorasi'])->name('eksplorasi');
    Route::get('/umkm/{id}', [MitraController::class, 'show'])->name('umkm.show');
Route::post('/ajukan-kerjasama/{id}', [MitraController::class, 'ajukanKerjasama'])->name('ajukan.kerjasama');
// Route::post('/ajukan-kerjasama/{id}', [MitraController::class, 'ajukanKerjasama'])->name('mitra.ajukan.kerjasama');
    Route::resource('events', EventController::class)->only(['index', 'create', 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';