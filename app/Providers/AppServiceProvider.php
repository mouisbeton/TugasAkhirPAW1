<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated; // <--- Import Penting
use Illuminate\Support\Facades\Auth; // <--- Import Penting

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
        // ATURAN GLOBAL:
        // Jika user sudah login tapi nyasar ke halaman login lagi,
        // Jangan lempar ke /dashboard, tapi cek dulu role-nya.
        
        RedirectIfAuthenticated::redirectUsing(function () {
            if (Auth::user() && Auth::user()->isAdmin()) {
                return route('dashboard');
            }
            return route('student.dashboard');
        });
    }
}