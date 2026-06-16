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

   Route::get('/debug-foto2', function () {
    $results = [];
    
    // Cek semua kemungkinan lokasi
    $filePath = 'catatan/5/1767008837_69526a454d1ba.jpg';
    
    $locations = [
        'public/storage/'        => public_path('storage/' . $filePath),
        'storage/app/public/'    => storage_path('app/public/' . $filePath),
        'storage/app/'           => storage_path('app/' . $filePath),
        'public/'                => public_path($filePath),
    ];
    
    foreach ($locations as $label => $path) {
        $results[$label] = [
            'path'   => $path,
            'exists' => file_exists($path) ? 'ADA' : 'TIDAK ADA',
        ];
    }
    
    // Cek isi folder storage/app/public
    $storagePub = storage_path('app/public');
    if (is_dir($storagePub)) {
        $results['storage_app_public_contents'] = scandir($storagePub);
    }
    
    // Cek isi folder storage/app/public/catatan jika ada
    $catatanDir = storage_path('app/public/catatan');
    if (is_dir($catatanDir)) {
        $results['catatan_folder'] = scandir($catatanDir);
    } else {
        $results['catatan_folder'] = 'TIDAK ADA';
    }

    // Cek public/storage symlink
    $results['public_storage_is_link'] = is_link(public_path('storage')) ? 'YA (symlink)' : 'BUKAN symlink';
    $results['public_storage_link_target'] = is_link(public_path('storage')) ? readlink(public_path('storage')) : 'N/A';
    
    return response()->json($results, 200, [], JSON_PRETTY_PRINT);
})->middleware('auth');

Route::get('/debug-storage', function () {
    return response()->json([
        'is_link'      => is_link(public_path('storage')) ? 'YA symlink' : 'BUKAN symlink',
        'link_target'  => is_link(public_path('storage')) ? readlink(public_path('storage')) : 'N/A',
        'folder_exists'=> is_dir(public_path('storage')) ? 'ADA' : 'TIDAK ADA',
        'storage_app_public' => is_dir(storage_path('app/public')) ? scandir(storage_path('app/public')) : 'TIDAK ADA',
    ]);
});