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

Route::get('/user', function (Request $request) {
    return $request->user(); // Tidak menggunakan auth:sanctum
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user(); // Tidak menggunakan middleware auth
});

Route::post('/logout', [LogoutController::class, 'logout']);

Route::get('/detailMHS/{id}', [DetailMHSController::class, 'getUserProfile']);

Route::get('/tugas', [TugasMahasiswaController::class, 'tugasSemua']);

Route::get('/progres', [TugasKompenController::class, 'progresMahasiswa']);

Route::get('/dashboardMHS/{id_mahasiswa}', [DashboardMahasiswaController::class, 'getDashboardMHS']);
