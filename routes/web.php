// Lokasi File: C:\Users\mohiq\backand_plarena\routes\web.php

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File; // Pastikan facade File ini diimpor

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang
| berisi grup middleware "web".
|
*/

// -----------------------------------------------------------------------------
// CONTOH RUTE WEB LARAVEL (Jika Anda membutuhkannya)
// -----------------------------------------------------------------------------
// Route::get('/halaman-khusus-laravel', function () {
//     return 'Ini adalah halaman yang dilayani oleh Laravel.';
// });
// -----------------------------------------------------------------------------


// -----------------------------------------------------------------------------
// RUTE "CATCH-ALL" UNTUK MENYAJIKAN APLIKASI FRONTEND (NEXT.JS SPA)
// -----------------------------------------------------------------------------
Route::get('/{any?}', function ($any = null) {
    // Pastikan 'frontend_build' adalah nama folder yang Anda gunakan di direktori public Laravel
    $frontendIndexPath = public_path('frontend_build/index.html');

    if (File::exists($frontendIndexPath)) {
        return File::get($frontendIndexPath);
    }
    abort(404, 'Halaman Aplikasi Frontend Tidak Ditemukan.');
})->where('any', '.*');