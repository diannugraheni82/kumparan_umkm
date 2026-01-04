<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// TAMBAHKAN 3 BARIS DI BAWAH INI:
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Kerjasama; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
             if (Auth::check() && Auth::user()->role == 'umkm') {
                 $umkm = Auth::user()->umkm;
                 
                 $notifikasi = [];
                 if ($umkm) {
                     $notifikasi = Kerjasama::where('umkm_id', $umkm->id)
                         ->where('status', 'pending')
                         ->with('mitra')
                         ->latest()
                         ->get();
                 }
                 
                 $view->with('notifikasiKerjasama', $notifikasi);
             } else {
                 $view->with('notifikasiKerjasama', collect());
             }
        });
    }
}