<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;

Route::get('/test', function () {
    return response()->json(['message' => 'API Connected!']);
});
Route::get('/admin/siswa', [SiswaController::class, 'index']);
Route::get('/admin/siswa/{id}', [SiswaController::class, 'show']);
