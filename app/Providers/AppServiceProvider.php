<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Sesuaikan jika path home Anda berbeda (misalnya '/home')

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api') // Ini menambahkan prefix /api untuk semua rute di routes/api.php
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            // Mengembalikan batasan 60 request per menit berdasarkan ID pengguna yang diautentikasi atau alamat IP.
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Anda bisa menambahkan konfigurasi RateLimiter lain di sini jika perlu
        // RateLimiter::for('custom_limiter', function (Request $request) {
        //     return Limit::perHour(1000)->by($request->ip());
        // });
    }
}