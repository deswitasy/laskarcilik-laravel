<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Guru\CatatanController as GuruCatatanController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('siswa', AdminSiswaController::class);
        Route::resource('guru', AdminGuruController::class);
    });

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');

        Route::get('/siswa', [GuruCatatanController::class, 'daftarSiswa'])->name('siswa.index');
        Route::get('/siswa/{id}', [GuruCatatanController::class, 'detailSiswa'])->name('siswa.show');

        Route::get('/catatan', [GuruCatatanController::class, 'indexCatatan'])->name('catatan.index');
        Route::get('/catatan/create', [GuruCatatanController::class, 'create'])->name('catatan.create');
        Route::post('/catatan', [GuruCatatanController::class, 'store'])->name('catatan.store');
        Route::get('/catatan/{id}', [GuruCatatanController::class, 'show'])->name('catatan.show');
        Route::get('/catatan/{id}/edit', [GuruCatatanController::class, 'edit'])->name('catatan.edit');
        Route::put('/catatan/{id}', [GuruCatatanController::class, 'update'])->name('catatan.update');
        Route::delete('/catatan/{id}', [GuruCatatanController::class, 'destroy'])->name('catatan.destroy');
        Route::get('/catatan/{id}/pdf', [GuruCatatanController::class, 'cetakPDF'])->name('catatan.pdf');
    });
