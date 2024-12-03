<?php

use App\Http\Controllers\aAdminController;
use App\Http\Controllers\aBidangKompetensiController;
use App\Http\Controllers\aDosenController;
use App\Http\Controllers\aLevelController;
use App\Http\Controllers\aMahasiswaAlphaController;
use App\Http\Controllers\aMahasiswaController;
use App\Http\Controllers\aTendikController;
use App\Http\Controllers\aWelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// {{ For Admin }}
// dashboard
Route::get('/admin', [aWelcomeController::class, 'index']);
// level
Route::group(['prefix' => 'aLevel'], function () {
    Route::get('/', [aLevelController::class, 'index']);
    Route::post('/list', [aLevelController::class, 'list']);
    Route::get('/{id}/show_ajax', [aLevelController::class, 'show_ajax']);
});

// user mahasiswa
Route::group(['prefix' => 'aMahasiswa'], function () {
    Route::get('/', [aMahasiswaController::class, 'index']);
    Route::post('/list', [aMahasiswaController::class, 'list']);
    Route::get('/{id}/show_ajax', [aMahasiswaController::class, 'show_ajax']);
    Route::get('/create_ajax', [aMahasiswaController::class, 'create_ajax']);
    Route::post('/ajax', [aMahasiswaController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aMahasiswaController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aMahasiswaController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aMahasiswaController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aMahasiswaController::class, 'delete_ajax']);
});

// user admin
Route::group(['prefix' => 'aAdmin'], function () {
    Route::get('/', [aAdminController::class, 'index']);
    Route::post('/list', [aAdminController::class, 'list']);
    Route::get('/{id}/show_ajax', [aAdminController::class, 'show_ajax']);
});

// user dosen
Route::group(['prefix' => 'aDosen'], function () {
    Route::get('/', [aDosenController::class, 'index']);
    Route::post('/list', [aDosenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aDosenController::class, 'show_ajax']);
});

// user tendik
Route::group(['prefix' => 'aTendik'], function () {
    Route::get('/', [aTendikController::class, 'index']);
    Route::post('/list', [aTendikController::class, 'list']);
    Route::get('/{id}/show_ajax', [aTendikController::class, 'show_ajax']);
});

// daftar mahasiswa alpha
Route::group(['prefix' => 'aMahasiswaAlpha'], function () {
    Route::get('/', [aMahasiswaAlphaController::class, 'index']);
    Route::post('/list', [aMahasiswaAlphaController::class, 'list']);
    Route::get('/{id}/show_ajax', [aMahasiswaAlphaController::class, 'show_ajax']);
});

// manage bidang kompetensi
Route::group(['prefix' => 'aBidangKompetensi'], function () {
    Route::get('/', [aBidangKompetensiController::class, 'index']);
    Route::post('/list', [aBidangKompetensiController::class, 'list']);
    Route::get('/{id}/show_ajax', [aBidangKompetensiController::class, 'show_ajax']);
});
