<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;



Route::get('/', function () {
    return view('welcome'); 
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::resource('karyawan', KaryawanController::class)->only(['index']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/import', [AbsensiController::class, 'import'])->name('absensi.import');
    Route::post('/absensi/proses', [AbsensiController::class, 'prosesTanggal'])->name('absensi.proses');

    Route::get('/absensi/{absen}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{absen}', [AbsensiController::class, 'update'])->name('absensi.update');

    Route::get('/absensi/log-mentah', [AbsensiController::class, 'logMentah'])->name('absensi.logMentah');

    Route::get('/absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');
    Route::post('/karyawan/import', [KaryawanController::class, 'import'])->name('karyawan.import');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/absensi', [AbsensiController::class, 'index'])
        ->name('absensi.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/karyawan', [KaryawanController::class, 'index'])
        ->name('karyawan.index');

    Route::get('/riwayat-absen', [AbsenMentahController::class, 'index'])
        ->name('absen.mentah.index');

    Route::get('/import-finger', [ImportFingerController::class, 'index'])
        ->name('import.finger.index');

    Route::post('/import-finger', [ImportFingerController::class, 'store'])
        ->name('import.finger.store');

    Route::get('/absensi/dashboard', [AbsensiController::class, 'dashboard'])
         ->name('absensi.dashboard');

});


require __DIR__.'/auth.php';
