<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\AnakPantiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\PenerimaanDonasiController; // Tambahkan ini

// ====================== DASHBOARD REDIRECT ======================
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('staff.dashboard');
})->middleware('auth')->name('dashboard');

// ====================== IMPORT TEMPLATE ROUTE ======================
Route::get('/admin/import/template/{type}', [ImportController::class, 'downloadTemplate'])
    ->name('admin.import.template');

// ====================== ADMIN AREA ======================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->as('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Donatur - Lengkap
        Route::resource('donatur', DonaturController::class)->except(['show']);
        Route::get('donatur/trash', [DonaturController::class, 'trash'])->name('donatur.trash');
        Route::patch('donatur/restore/{kode_donatur}', [DonaturController::class, 'restore'])->name('donatur.restore');
        Route::delete('donatur/force-delete/{kode_donatur}', [DonaturController::class, 'forceDelete'])->name('donatur.forceDelete');
        Route::delete('donatur/force-delete-all', [DonaturController::class, 'forceDeleteAll'])->name('donatur.force-delete-all');
        Route::post('donatur/truncate', [DonaturController::class, 'truncate'])->name('donatur.truncate');
        Route::post('donatur/import', [ImportController::class, 'donatur'])->name('donatur.import');
        Route::get('donatur/{kode_donatur}/struk', [DonaturController::class, 'struk'])
            ->name('donatur.struk');

        // Anak Panti - Lengkap
        Route::resource('anak-panti', AnakPantiController::class)->except(['show']);
        Route::post('anak-panti/import', [ImportController::class, 'anakPanti'])->name('anak-panti.import');
        Route::post('anak-panti/truncate', [AnakPantiController::class, 'truncate'])->name('anak-panti.truncate');

        // Penerimaan Donasi - Admin (full access)
        Route::resource('penerimaan-donasi', PenerimaanDonasiController::class)->except(['show']);
        
        // TAMBAHAN: Route untuk cetak struk donasi per transaksi
        Route::get('penerimaan-donasi/{id}/struk', [PenerimaanDonasiController::class, 'struk'])
            ->name('penerimaan-donasi.struk');

        // Pengeluaran
        Route::resource('pengeluaran', App\Http\Controllers\Admin\PengeluaranController::class)->except(['show']);

        // Jurnal Umum
        Route::resource('jurnal-umum', App\Http\Controllers\Admin\JurnalUmumController::class)->except(['show']);

        // Daftar Akun & Saldo Awal
        Route::resource('daftar-akun', App\Http\Controllers\Admin\DaftarAkunController::class)->except(['show']);
        Route::resource('saldo-awal', App\Http\Controllers\Admin\SaldoAwalController::class)->only(['index', 'store']);
        Route::get('saldo-awal/export/all', [App\Http\Controllers\Admin\SaldoAwalController::class, 'exportAll'])->name('saldo-awal.export.all');
        Route::post('saldo-awal/export/kelompok', [App\Http\Controllers\Admin\SaldoAwalController::class, 'exportKelompok'])->name('saldo-awal.export.kelompok');
        Route::get('saldo-awal/export/pdf', [App\Http\Controllers\Admin\SaldoAwalController::class, 'exportPdf'])->name('saldo-awal.pdf');

        // Aset Tetap
        Route::resource('aset-tetap', App\Http\Controllers\Admin\AsetTetapController::class)->except(['show']);

        // Laporan
        Route::get('laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/export/pdf', [App\Http\Controllers\Admin\ExportController::class, 'laporanPdf'])->name('laporan.pdf');
        Route::get('laporan/export/excel', [App\Http\Controllers\Admin\ExportController::class, 'laporanExcel'])->name('laporan.excel');

        // Identitas Panti
        Route::get('identitas-panti/edit', [App\Http\Controllers\Admin\IdentitasPantiController::class, 'edit'])->name('identitas-panti.edit');
        Route::put('identitas-panti', [App\Http\Controllers\Admin\IdentitasPantiController::class, 'update'])->name('identitas-panti.update');

        // Audit Log
        Route::get('audit-log', [App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-log.index');

        // Profile & Staff
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::resource('staff', StaffController::class)->except(['show']);
   
        Route::resource('inventaris', App\Http\Controllers\Admin\InventarisController::class)
            ->except(['show']);
   
    });

// ====================== STAFF AREA ======================
Route::prefix('staff')
    ->middleware(['auth', 'role:staff'])
    ->as('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // Penerimaan Donasi - Staff hanya create & store
        Route::get('penerimaan-donasi/create', [App\Http\Controllers\Staff\PenerimaanDonasiController::class, 'create'])
            ->name('penerimaan-donasi.create');
        Route::post('penerimaan-donasi', [App\Http\Controllers\Staff\PenerimaanDonasiController::class, 'store'])
            ->name('penerimaan-donasi.store');

        // TAMBAHAN: Staff juga bisa cetak struk transaksi yang dibuatnya
        Route::get('penerimaan-donasi/{id}/struk', [App\Http\Controllers\Admin\PenerimaanDonasiController::class, 'struk'])
            ->name('penerimaan-donasi.struk');

        // Pengeluaran - Staff
        Route::get('pengeluaran/create', [App\Http\Controllers\Staff\PengeluaranController::class, 'create'])
            ->name('pengeluaran.create');
        Route::post('pengeluaran', [App\Http\Controllers\Staff\PengeluaranController::class, 'store'])
            ->name('pengeluaran.store');

        // Jurnal Umum (read-only untuk staff)
        Route::get('jurnal-umum', [App\Http\Controllers\Admin\JurnalUmumController::class, 'index'])
            ->name('jurnal-umum.index');



    });

// ====================== AUTH & WELCOME ======================
require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});