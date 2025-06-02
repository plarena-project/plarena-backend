<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controller Anda di sini. Sesuaikan namespace jika perlu.
// Contoh:
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;

// Controller untuk User yang terotentikasi
use App\Http\Controllers\Api\User\UserProfileController;
use App\Http\Controllers\Api\User\PesananUserController;
use App\Http\Controllers\Api\User\PembayaranUserController;
// use App\Http\Controllers\Api\User\LapanganUserController; // Jika ada logika khusus

// Controller untuk Admin
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminLapanganController;
use App\Http\Controllers\Api\Admin\AdminMemberController;
use App\Http\Controllers\Api\Admin\AdminPesananController;
use App\Http\Controllers\Api\Admin\AdminPembayaranController;
// use App\Http\Controllers\Api\Admin\AdminDataAdminController; // Jika ada

use App\Http\Controllers\Api\PaymentWebhookController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang
| akan diberi grup middleware "api". Nikmati pembuatan API Anda!
|
| Semua rute yang didefinisikan di sini akan otomatis memiliki prefix /api/
| Contoh: /api/login, /api/lapangan/list
*/

// == RUTE PUBLIK ==
// Rute-rute ini tidak memerlukan otentikasi.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/lapangan/list', [PublicController::class, 'listLapanganPublik']);
Route::get('/lapangan/detail/{id}', [PublicController::class, 'detailLapanganPublik']);
// Tambahkan rute publik lainnya jika ada (misalnya, kategori, artikel, dll.)


// == RUTE YANG MEMERLUKAN OTENTIKASI (UNTUK USER BIASA DAN ADMIN) ==
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']); // Mendapatkan data user yang sedang login

    // == RUTE SPESIFIK UNTUK USER YANG TEROTENTIKASI ==
    Route::prefix('user')->name('user.')->group(function () { // name() untuk kemudahan generate URL jika perlu
        Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

        // Pesanan oleh User
        Route::get('/pesanan', [PesananUserController::class, 'index'])->name('pesanan.index');
        Route::post('/pesanan', [PesananUserController::class, 'store'])->name('pesanan.store');
        Route::get('/pesanan/{id}', [PesananUserController::class, 'show'])->name('pesanan.show');
        Route::put('/pesanan/{id}/cancel', [PesananUserController::class, 'cancel'])->name('pesanan.cancel');

        // Pembayaran oleh User
        Route::get('/pembayaran', [PembayaranUserController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/initiate', [PembayaranUserController::class, 'initiate'])->name('pembayaran.initiate');
        Route::post('/pembayaran/confirm', [PembayaranUserController::class, 'confirm'])->name('pembayaran.confirm');
    });


    // == RUTE SPESIFIK UNTUK ADMIN ==
    // Anda perlu membuat middleware 'isAdmin' dan meregistrasikannya di app/Http/Kernel.php
    // Route::middleware('isAdmin')->prefix('admin')->name('admin.')->group(function () {
    // Jika belum ada middleware isAdmin, Anda bisa memproteksi di level controller atau service provider
    // Untuk contoh ini, kita asumsikan proteksi ada di controller atau belum diimplementasi di middleware rute
    Route::prefix('admin')->name('admin.')->group(function () { // Proteksi dengan middleware 'isAdmin' lebih baik
        Route::get('/dashboard', [AdminDashboardController::class, 'summary'])->name('dashboard.summary');

        // CRUD untuk Lapangan oleh Admin
        Route::apiResource('lapangan', AdminLapanganController::class); // menghasilkan .index, .store, .show, .update, .destroy

        // CRUD untuk Member oleh Admin
        Route::apiResource('member', AdminMemberController::class);

        // Pengelolaan Pesanan oleh Admin
        Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index.admin');
        Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show.admin');
        Route::put('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updatestatus.admin');

        // Pengelolaan Pembayaran oleh Admin
        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index.admin');
        Route::get('/pembayaran/{id}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show.admin');
        Route::post('/pembayaran/{id}/verify', [AdminPembayaranController::class, 'verify'])->name('pembayaran.verify.admin');

        // Jika ada manajemen admin oleh superadmin:
        // Route::apiResource('data-admin', AdminDataAdminController::class)->middleware('isSuperAdmin'); // Contoh middleware lain
    });
});


// == RUTE UNTUK WEBHOOK DARI PAYMENT GATEWAY ==
// Rute ini biasanya tidak memerlukan otentikasi sesi/token dari user/admin,
// tetapi mungkin memiliki mekanisme verifikasi sendiri (misalnya signature dari payment gateway).
Route::post('/payment/webhook', [PaymentWebhookController::class, 'handle']);