<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\LapanganController;
use Illuminate\Support\Facades\Request;

Route::post('/login', LoginController::class);

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/admins', [AdminController::class, 'index']);
Route::post('/admins', [AdminController::class, 'store']);
Route::put('/admins/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

Route::get('/pesanan', [PesananController::class, 'index']);
Route::post('/pesanan', [PesananController::class, 'store']);
Route::put('/pesanan/{id}', [PesananController::class, 'update']);
Route::delete('/pesanan/{id}', [PesananController::class, 'destroy']);

Route::get('/lapangans', [LapanganController::class, 'index']);
Route::post('/lapangans', [LapanganController::class, 'store']);
Route::put('/lapangans/{id}', [LapanganController::class, 'update']);
Route::delete('/lapangans/{id}', [LapanganController::class, 'destroy']);
Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return $request->user();
});
