<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Kerjasama; 
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';
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
        if (config('app.env') === 'production' || env('FORCE_HTTPS', true)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

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