<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\PengujiController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\ItemMateriController;
use App\Http\Controllers\Admin\PesertaController as AdminPesertaController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Lembaga\PesertaController as LembagaPesertaController;
use App\Http\Controllers\Penguji\NilaiController as PengujiNilaiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ExportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ===== ADMIN ROUTES =====
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('lembaga', LembagaController::class);
        Route::resource('penguji', PengujiController::class);
        Route::resource('materi', MateriController::class);
        Route::resource('materi.item', ItemMateriController::class);

        // Peserta - dengan parameter binding manual
        Route::resource('peserta', AdminPesertaController::class)->parameters([
            'peserta' => 'peserta'
        ]);

        Route::get('/nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/{peserta}', [AdminNilaiController::class, 'show'])->name('nilai.show');

        // Laporan PDF
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/kartu-nilai/{peserta}', [LaporanController::class, 'kartuNilai'])->name('laporan.kartu-nilai');
        Route::post('/laporan/rekap-lembaga', [LaporanController::class, 'rekapLembaga'])->name('laporan.rekap-lembaga');
        Route::get('/laporan/rekap-keseluruhan', [LaporanController::class, 'rekapKeseluruhan'])->name('laporan.rekap-keseluruhan');

        // Export Excel
        Route::get('/export', [ExportController::class, 'index'])->name('export.index');
        Route::post('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');

        // Placeholder
        Route::get('/log', [\App\Http\Controllers\Admin\LogController::class, 'index'])->name('log.index');

        // Di dalam Route::prefix('admin')->name('admin.')->middleware('role:admin')->group
        Route::get('/nilai/{peserta}/edit', [\App\Http\Controllers\Admin\NilaiEditController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{peserta}', [\App\Http\Controllers\Admin\NilaiEditController::class, 'update'])->name('nilai.update');
        Route::get('/nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/{peserta}', [AdminNilaiController::class, 'show'])->name('nilai.show');
        Route::get('/nilai/{peserta}/edit', [\App\Http\Controllers\Admin\NilaiEditController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{peserta}', [\App\Http\Controllers\Admin\NilaiEditController::class, 'update'])->name('nilai.update');

        // Di dalam Route::prefix('admin')->name('admin.')->middleware('role:admin')->group
        Route::get('/import-export', [\App\Http\Controllers\Admin\ImportExportController::class, 'index'])->name('import-export.index');
        Route::post('/export', [\App\Http\Controllers\Admin\ImportExportController::class, 'export'])->name('export');
        Route::post('/import', [\App\Http\Controllers\Admin\ImportExportController::class, 'import'])->name('import');
        Route::get('/download-template', [\App\Http\Controllers\Admin\ImportExportController::class, 'downloadTemplate'])->name('download-template');

    });

    // ===== LEMBAGA ROUTES =====
    Route::prefix('lembaga-user')->name('lembaga.')->middleware('role:lembaga')->group(function () {
        Route::resource('peserta', LembagaPesertaController::class)->parameters([
            'peserta' => 'peserta'
        ]);
        Route::get('/nilai', fn() => 'Coming Soon')->name('nilai.index');
        // Di dalam Route::prefix('lembaga-user')->name('lembaga.')->middleware('role:lembaga')->group
        Route::get('/import-export', [\App\Http\Controllers\Lembaga\ImportExportController::class, 'index'])->name('import-export.index');
        Route::post('/export', [\App\Http\Controllers\Lembaga\ImportExportController::class, 'export'])->name('export');
        Route::post('/import', [\App\Http\Controllers\Lembaga\ImportExportController::class, 'import'])->name('import');
        Route::get('/download-template', [\App\Http\Controllers\Lembaga\ImportExportController::class, 'downloadTemplate'])->name('download-template');
    });

    // ===== PENGUJI ROUTES =====
    Route::prefix('penguji-user')->name('penguji.')->middleware('role:penguji')->group(function () {
        Route::get('/nilai', [PengujiNilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/{peserta}', [PengujiNilaiController::class, 'show'])->name('nilai.show');
        Route::post('/nilai/{peserta}', [PengujiNilaiController::class, 'store'])->name('nilai.store');
        Route::get('/notifikasi', fn() => 'Coming Soon')->name('notifikasi.index');
    });
});