<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VerifikasiUmkmController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// --- REDIRECT UTAMA ---
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// --- AUTHENTICATION ---
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

// --- AREA ADMIN (Backend 2) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Verifikasi UMKM
    Route::get('/admin/verifikasi', [VerifikasiUmkmController::class, 'index'])->name('admin.verifikasi.index');    
    Route::post('/admin/verifikasi/{id}', [VerifikasiUmkmController::class, 'updateStatus'])->name('admin.verifikasi.update');

    // Cetak PDF
    Route::get('/admin/verifikasi/cetak', [VerifikasiUmkmController::class, 'cetakPdf'])->name('admin.verifikasi.cetak');

    // Logout & Nav Fix
    Route::get('/profile', function() { return "Profile Page"; })->name('profile.edit');
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});