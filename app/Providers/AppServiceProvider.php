<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        //
        // Batasi submit form koordinat (POST /coordinate) biar gak bisa dispam bot,
        // 8x per menit per IP — cukup longgar buat user asli yang mungkin retry
        // beberapa kali karena koneksi lambat, tapi ketat buat spam otomatis.
        RateLimiter::for('coordinate', function (Request $request) {
            return Limit::perMinute(8)->by($request->ip());
        });
    }
}