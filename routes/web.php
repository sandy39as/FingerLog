<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsenMentahController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenHarianController;
use App\Http\Controllers\ShiftKerjaController;
use App\Http\Controllers\DepartemenController;

Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ROUTE YANG BUTUH LOGIN
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // IMPORT KARYAWAN — TARUH DIATAS RESOURCE
    Route::get('/karyawan/import', [KaryawanController::class, 'importForm'])->name('karyawan.import');
    Route::post('/karyawan/import', [KaryawanController::class, 'importStore'])->name('karyawan.import.store');

    // RESOURCE KARYAWAN (include show)
    Route::resource('karyawan', KaryawanController::class);

    // Absen Mentah
    Route::get('/absen-mentah', [AbsenMentahController::class, 'index'])->name('absen-mentah.index');
    Route::get('/absen-mentah/import', [AbsenMentahController::class, 'importForm'])->name('absen-mentah.import');
    Route::post('/absen-mentah/import', [AbsenMentahController::class, 'importStore'])->name('absen-mentah.import.store');

    // Absen Harian
    Route::get('/absen-harian', [AbsenHarianController::class, 'index'])->name('absen-harian.index');
    Route::post('/absen-harian/proses', [AbsenHarianController::class, 'proses'])->name('absen-harian.proses');

    // Export Absen Harian
    Route::get('/absen-harian/export', [AbsenHarianController::class, 'export'])->name('absen-harian.export');

    // Shift Kerja
    Route::resource('shift', ShiftKerjaController::class)->except(['show']);

    // Departemen
    Route::resource('departemen', DepartemenController::class)
        ->parameters(['departemen' => 'departemen'])
        ->except(['show']);


});

require __DIR__.'/auth.php';
