<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LihatPilihKompenController;
use App\Http\Controllers\UpdateProgresTugasKompenController;
use App\Http\Controllers\UpdateKompenSelesaiController;
use App\Http\Controllers\mWelcomeController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 1. Mahasiswa dahboard
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mahasiswa/dashboard', [mWelcomeController::class, 'index'])->name('api.mahasiswa.dashboard');
});
// 2. API Route untuk Register Mahasiswa
Route::post('/register', [AuthController::class, 'registerMahasiswa']);

// 3. API Route untuk Login Mahasiswa
Route::post('/mahasiswa/login', [AuthController::class, 'loginMahasiswa'])->name('api.login.mahasiswa');

// 4. Lihat dan Pilih Kompen
Route::get('/api/lihat-kompen', [LihatPilihKompenController::class, 'getTugasReady'])->name('api.lihatKompen');

// 5. Lihat Data Progres Tugas Kompen
Route::get('/api/progres-tugas', [UpdateProgresTugasKompenController::class, 'index'])->name('api.progresTugas');

// 6. Ambil Data Tugas Spesifik (Detail berdasarkan ID)
Route::get('/api/progres-tugas/{id}', [UpdateProgresTugasKompenController::class, 'fetchTugasData'])->name('api.progresTugas.detail');

// 7. Lihat Data Kompen Selesai
Route::get('/api/kompen-selesai', [UpdateKompenSelesaiController::class, 'index'])->name('api.kompenSelesai');
