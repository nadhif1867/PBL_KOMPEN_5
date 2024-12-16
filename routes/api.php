<?php

use App\Http\Controllers\Api\BidkomController;
use App\Http\Controllers\Api\DashboardMahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DetailMHSController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\mProgresTugasController;
use App\Http\Controllers\Api\mWelcomeController;
use App\Http\Controllers\Api\TugasKompenController;
use App\Http\Controllers\Api\TugasMahasiswaController;
use App\Models\mTugasKompenModel;
use App\Models\ProgresTugasModel;
use App\Models\TugasMahasiswaModel;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/detailMHS/{id}', [DetailMHSController::class, 'getUserProfile'])
    ->name('getUserProfile');

Route::get('/tugas', [TugasMahasiswaController::class, 'tugasSemua'])->name('tugasSemua');

Route::get('/progres', [TugasKompenController::class, 'progresMahasiswa'])->name('progresMahasiswa');

Route::get('/dashboardMHS/{id_mahasiswa}', [DashboardMahasiswaController::class, 'getDashboardMHS'])->name('getDashboardMHS');
