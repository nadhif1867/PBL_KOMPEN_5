<?php

use App\Http\Controllers\aAdminController;
use App\Http\Controllers\aBidangKompetensiController;
use App\Http\Controllers\aDosenController;
use App\Http\Controllers\aJenisKompenController;
use App\Http\Controllers\aLevelController;
use App\Http\Controllers\aMahasiswaAlphaController;
use App\Http\Controllers\aMahasiswaController;
use App\Http\Controllers\aMahasiswaKompenController;
use App\Http\Controllers\aManageKompenController;
use App\Http\Controllers\aManageMahasiswaKompenController;
use App\Http\Controllers\aProfileController;
use App\Http\Controllers\aTendikController;
use App\Http\Controllers\aTugasAdminController;
use App\Http\Controllers\aTugasDosenController;
use App\Http\Controllers\aTugasKompenController;
use App\Http\Controllers\aTugasTendikController;
use App\Http\Controllers\aWelcomeController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dMahasiswaAlphaController;
use App\Http\Controllers\dMahasiswaKompenController;
use App\Http\Controllers\dManageKompenController;
use App\Http\Controllers\dWelcomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\mWelcomeController;

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

// landing page
Route::get('/', [LandingPageController::class, 'index']);

// login admin
// Login routes
Route::get('/login/mahasiswa', [AuthController::class, 'showMahasiswaLogin'])->name('login.mahasiswa');
Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa'])->name('login.mahasiswa');

Route::get('/login/dosen', [AuthController::class, 'showDosenLogin'])->name('login.dosen');
Route::post('/login/dosen', [AuthController::class, 'dosenLogin']);

Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin');

// Register Mahasiswa
// Route::get('/register', [AuthController::class, 'showMahasiswaRegister'])->name('register.mahasiswa'); // Untuk form registrasi
// Route::post('/register', [AuthController::class, 'registerMahasiswa'])->name('register.mahasiswa'); // Proses registrasi

// Login Mahasiswa
Route::get('/login/mahasiswa', [AuthController::class, 'showMahasiswaLogin'])->name('login.mahasiswa');
Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa']);

// Register Mahasiswa
Route::get('/register', [AuthController::class, 'showMahasiswaRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerMahasiswa'])->name('register');

// Login Admin
Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// Tampilkan halaman login dosen/teknisi
Route::get('/login/dosen', [AuthController::class, 'showDosenLogin'])->name('login.dosen');

// Proses login dosen/teknisi
Route::post('/login/dosen', [AuthController::class, 'dosenLogin'])->name('login.dosen');


// Welcome for Mahasiswa
// Route::get('/Mahasiswa', [WelcomeController::class, 'index'])->name('mahasiswa.dashboard');


// Welcome for Dosen/Teknisi
// Route::get('/DosenTeknisi', [dtWelcomeController::class, 'index'])->name('dosenTeknisi.dashboard');

// Route Login Admin
// Route::pattern('id', '[0-9]+');

// Route::get('admin_login', [AuthController::class, 'adminlogin'])->name('adminlogin');
// Route::post('admin_login', [AuthController::class, 'adminpostlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

// Route::middleware(['auth'])->group(function () {

// {{ For Admin }}
// dashboard
Route::get('/admin', [aWelcomeController::class, 'index'])->name('admin.dashboard');

// profile
Route::group(['prefix' => 'aProfile'], function () {
    Route::get('/', [aProfileController::class, 'index']);
    Route::get('/edit_ajax', [aProfileController::class, 'edit_ajax']);
    Route::post('/update_ajax', [aProfileController::class, 'update_ajax']);
});

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
    Route::get('/create_ajax', [aAdminController::class, 'create_ajax']);
    Route::post('/ajax', [aAdminController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aAdminController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aAdminController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aAdminController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aAdminController::class, 'delete_ajax']);
});

// user dosen
Route::group(['prefix' => 'aDosen'], function () {
    Route::get('/', [aDosenController::class, 'index']);
    Route::post('/list', [aDosenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aDosenController::class, 'show_ajax']);
    Route::get('/create_ajax', [aDosenController::class, 'create_ajax']);
    Route::post('/ajax', [aDosenController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aDosenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aDosenController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aDosenController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aDosenController::class, 'delete_ajax']);
});

// user tendik
Route::group(['prefix' => 'aTendik'], function () {
    Route::get('/', [aTendikController::class, 'index']);
    Route::post('/list', [aTendikController::class, 'list']);
    Route::get('/{id}/show_ajax', [aTendikController::class, 'show_ajax']);
    Route::get('/create_ajax', [aTendikController::class, 'create_ajax']);
    Route::post('/ajax', [aTendikController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aTendikController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aTendikController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aTendikController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aTendikController::class, 'delete_ajax']);
});

// daftar mahasiswa alpha
Route::group(['prefix' => 'aMahasiswaAlpha'], function () {
    Route::get('/', [aMahasiswaAlphaController::class, 'index']);
    Route::post('/list', [aMahasiswaAlphaController::class, 'list']);
    Route::get('/{id}/show_ajax', [aMahasiswaAlphaController::class, 'show_ajax']);
    Route::get('/import', [aMahasiswaAlphaController::class, 'import']);
    Route::post('/import_ajax', [aMahasiswaAlphaController::class, 'import_ajax']);
});

// daftar mahasiswa kompen
Route::group(['prefix' => 'aMahasiswaKompen'], function () {
    Route::get('/', [aMahasiswaKompenController::class, 'index']);
    Route::post('/list', [aMahasiswaKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aMahasiswaKompenController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [aMahasiswaKompenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aMahasiswaKompenController::class, 'update_ajax']);
    Route::get('/import', [aMahasiswaKompenController::class, 'import']);
    Route::post('/import_ajax', [aMahasiswaKompenController::class, 'import_ajax']);
});

// manage bidang kompetensi
Route::group(['prefix' => 'aBidangKompetensi'], function () {
    Route::get('/', [aBidangKompetensiController::class, 'index']);
    Route::post('/list', [aBidangKompetensiController::class, 'list']);
    Route::get('/{id}/show_ajax', [aBidangKompetensiController::class, 'show_ajax']);
    Route::get('/create_ajax', [aBidangKompetensiController::class, 'create_ajax']);
    Route::post('/ajax', [aBidangKompetensiController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aBidangKompetensiController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aBidangKompetensiController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aBidangKompetensiController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aBidangKompetensiController::class, 'delete_ajax']);
});
// });

Route::group(['prefix' => 'aJenisKompen'], function () {
    Route::get('/', [aJenisKompenController::class, 'index']);
    Route::post('/list', [aJenisKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aJenisKompenController::class, 'show_ajax']);
    Route::get('/create_ajax', [aJenisKompenController::class, 'create_ajax']);
    Route::post('/ajax', [aJenisKompenController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aJenisKompenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aJenisKompenController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aJenisKompenController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aJenisKompenController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'aTugasAdmin'], function () {
    Route::get('/', [aTugasAdminController::class, 'index']);
    Route::post('/list', [aTugasAdminController::class, 'list']);
    Route::get('/{id}/show_ajax', [aTugasAdminController::class, 'show_ajax']);
});

Route::group(['prefix' => 'aTugasDosen'], function () {
    Route::get('/', [aTugasDosenController::class, 'index']);
    Route::post('/list', [aTugasDosenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aTugasDosenController::class, 'show_ajax']);
});

Route::group(['prefix' => 'aTugasTendik'], function () {
    Route::get('/', [aTugasTendikController::class, 'index']);
    Route::post('/list', [aTugasTendikController::class, 'list']);
    Route::get('/{id}/show_ajax', [aTugasTendikController::class, 'show_ajax']);
});

// Route::prefix('aTugasKompen')->group(function () {
//     Route::get('/', [aTugasKompenController::class, 'list'])->name('aTugasKompen.list');
//     Route::get('/create', [aTugasKompenController::class, 'create'])->name('aTugasKompen.create');
//     Route::post('/store', [aTugasKompenController::class, 'store'])->name('aTugasKompen.store');
//     Route::get('/edit/{id}', [aTugasKompenController::class, 'edit'])->name('aTugasKompen.edit');
//     Route::post('/update/{id}', [aTugasKompenController::class, 'update'])->name('aTugasKompen.update');
//     Route::delete('/delete/{id}', [aTugasKompenController::class, 'destroy'])->name('aTugasKompen.delete');
// });

Route::group(['prefix' => 'aManageKompen'], function () {
    Route::get('/', [aManageKompenController::class, 'index']);
    Route::post('/list', [aManageKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aManageKompenController::class, 'show_ajax']);
    Route::get('/create_ajax', [aManageKompenController::class, 'create_ajax']);
    Route::post('/ajax', [aManageKompenController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aManageKompenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aManageKompenController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aManageKompenController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aManageKompenController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'aManageMahasiswaKompen'], function () {
    Route::get('/', [aManageMahasiswaKompenController::class, 'index']);
    Route::post('/list', [aManageMahasiswaKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [aManageMahasiswaKompenController::class, 'show_ajax']);
    Route::get('/create_ajax', [aManageMahasiswaKompenController::class, 'create_ajax']);
    Route::post('/ajax', [aManageMahasiswaKompenController::class, 'store_ajax']);
    Route::get('{id}/edit_ajax', [aManageMahasiswaKompenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [aManageMahasiswaKompenController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [aManageMahasiswaKompenController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [aManageMahasiswaKompenController::class, 'delete_ajax']);
});

// {{ dosen }}
// dashboard
Route::get('/dosen', [dWelcomeController::class, 'index'])->name('dosen.dashboard');
// daftar mahasiswa alpha
Route::group(['prefix' => 'dMahasiswaAlpha'], function () {
    Route::get('/', [dMahasiswaAlphaController::class, 'index']);
    Route::post('/list', [dMahasiswaAlphaController::class, 'list']);
    Route::get('/{id}/show_ajax', [dMahasiswaAlphaController::class, 'show_ajax']);
    Route::get('/import', [dMahasiswaAlphaController::class, 'import']);
    Route::post('/import_ajax', [dMahasiswaAlphaController::class, 'import_ajax']);
});

// daftar mahasiswa kompen
Route::group(['prefix' => 'dMahasiswaKompen'], function () {
    Route::get('/', [dMahasiswaKompenController::class, 'index']);
    Route::post('/list', [dMahasiswaKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [dMahasiswaKompenController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [dMahasiswaKompenController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [dMahasiswaKompenController::class, 'update_ajax']);
    Route::get('/import', [dMahasiswaKompenController::class, 'import']);
    Route::post('/import_ajax', [dMahasiswaKompenController::class, 'import_ajax']);
});

// manage kompen
Route::group(['prefix' => 'dManageKompen'], function () {
    Route::get('/', [dManageKompenController::class, 'index']);
    Route::post('/list', [dManageKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [dManageKompenController::class, 'show_ajax']);
});


// {{ mahasiswa }}
// dashboard
Route::get('/mahasiswa', [mWelcomeController::class, 'index'])->name('mahasiswa.dashboard');
