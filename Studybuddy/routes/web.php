<?php

use App\Http\Controllers\AdminAnalitiksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminTugasController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\NotifikasiController;

// Route::get('/', function () {
//     return view('pages.Index.login', [
//         'title' => 'Login'
//     ]);
// })->name('index');

// Ghandi ndak bisa login aku pakek iki Route tanpa login Edit UI Login, Home
// Route::get('/', [LoginController::class, 'index'])->name('index');
// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::post('/storeCatatan', [CatatanController::class, 'store'])->name('storeCatatan');
// Route::delete('/deleteCatatan/{id}', [CatatanController::class, 'destroy'])->name('deleteCatatan');
// Route::put('/updateCatatan/{id}', [CatatanController::class, 'update'])->name('updateCatatan');


// fix routes
Route::get('/register/view', [RegisterController::class, 'index'])->name('registerForms');

Route::get('/', [LoginController::class, 'index'])->name('index');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/submitLogin', [LoginController::class, 'submitLogin'])->name('submitLogin');


Route::group(['middleware' => 'users'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/admin', [AdminAnalitiksController::class, 'index'])->name('adminPage');
    Route::get('/manageusers', [AdminUsersController::class, 'index'])->name('usersadmin');
    Route::get('/managekategori', [AdminKategoriController::class, 'index'])->name('kategoriadmin');
    Route::get('/managetugas', [AdminTugasController::class, 'index'])->name('tugasadmin');
});
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');

//route buat form buat catatannya
Route::post('/storeCatatan', [CatatanController::class, 'store'])->name('storeCatatan');
Route::put('/catatan/{id}/update-kategori', [CatatanController::class, 'updateKategori'])->name('updateKategori');
Route::post('/storeTugas', [TugasController::class, 'store'])->name('storeTugas');

//update data tabel jadwalharian
Route::put('/updateCatatan/{id}', [CatatanController::class, 'update'])->name('updateCatatan');
Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('updateTugas');

//route delete data jalwalharian dan tugas
Route::delete('/deleteCatatan/{id}', [CatatanController::class, 'destroy'])->name('deleteCatatan');
Route::delete('/deleteTugas/{id}', [TugasController::class, 'delete'])->name('deleteTugas');

//update kategori catatan// Di dalam routes/web.php
Route::put('/update-kategori/{id}', 'CatatanController@updateKategori')->name('updateKategori');

//route register user
Route::get('/register/view', [RegisterController::class, 'index'])->name('registerForms');
Route::post('/register/data', [RegisterController::class, 'submitRegister'])->name('submitRegister');

// Search Catatan
Route::post('/filterCatatan', 'CatatanController@filter')->name('filterCatatan');

// admin manage tabel user
Route::put('/edit-user/{id}', [AdminUsersController::class, 'editUser'])->name('editUser');
Route::delete('/delete-user/{id}', [AdminUsersController::class, 'deleteUser'])->name('deleteUser');
Route::post('/tambah-user', [AdminUsersController::class, 'storeUser'])->name('tambahUser');

// admin manage tabel kategori
Route::put('/edit-kategori/{id}', [AdminKategoriController::class, 'editKategori'])->name('editKategori');
Route::delete('/delete-kategori/{id}', [AdminKategoriController::class, 'deleteKategori'])->name('deleteKategori');
Route::post('/tambah-kategori', [AdminKategoriController::class, 'storeKategori'])->name('tambahKategori');


