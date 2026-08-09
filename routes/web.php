<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\AnakPantiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\PenerimaanDonasiController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\JurnalUmumController;
use App\Http\Controllers\Admin\DaftarAkunController;
use App\Http\Controllers\Admin\SaldoAwalController;
use App\Http\Controllers\Admin\AsetTetapController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\IdentitasPantiController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PersediaanMasukController;
use App\Http\Controllers\Admin\PersediaanKeluarController;
use App\Http\Controllers\Admin\DonasiBarangController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KasKecilController;
use App\Http\Controllers\Admin\TutupBukuController; // Tambahkan ini
use App\Http\Controllers\Admin\BukuBesarController; // Tambahkan ini
use App\Http\Controllers\Admin\ArusKasController;   // Tambahkan ini
use App\Http\Controllers\Admin\PenyusutanController; // Tambahkan ini

// Controllers khusus staff
use App\Http\Controllers\Staff\PenerimaanDonasiController as StaffPenerimaanDonasiController;
use App\Http\Controllers\Staff\PengeluaranController as StaffPengeluaranController;

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
    ->middleware(['auth', 'role:admin'])
    ->name('admin.import.template');

// ====================== ADMIN AREA ======================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->as('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Import Routes (semua di dalam group admin)
        Route::prefix('import')->group(function () {
            Route::get('/', [ImportController::class, 'index'])->name('import.index');
            
            Route::post('donatur', [ImportController::class, 'donatur'])->name('import.donatur');
            Route::post('anak-panti', [ImportController::class, 'anakPanti'])->name('import.anak-panti');
            Route::post('inventaris', [ImportController::class, 'inventaris'])->name('import.inventaris');
            Route::post('aset-tetap', [ImportController::class, 'asetTetap'])->name('import.aset-tetap');
        });

        // Download Template (tetap di luar prefix import agar lebih fleksibel)
        Route::get('/import/template/{type}', [ImportController::class, 'downloadTemplate'])
            ->name('import.template');

        // Donasi Barang
        Route::get('donasi-barang/export/pdf', [DonasiBarangController::class, 'exportPdf'])->name('donasi-barang.export.pdf');
        Route::resource('donasi-barang', DonasiBarangController::class);
        Route::get('donasi-barang/{id}/struk', [DonasiBarangController::class, 'struk'])->name('donasi-barang.struk');

        // Donatur
        Route::resource('donatur', DonaturController::class)->parameters(['donatur' => 'kode_donatur'])->except(['show']);
        Route::get('donatur/trash', [DonaturController::class, 'trash'])->name('donatur.trash');
        Route::patch('donatur/restore/{kode_donatur}', [DonaturController::class, 'restore'])->name('donatur.restore');
        Route::delete('donatur/force-delete/{kode_donatur}', [DonaturController::class, 'forceDelete'])->name('donatur.forceDelete');
        Route::post('donatur/force-delete-all', [DonaturController::class, 'forceDeleteAll'])->name('donatur.force-delete-all');
        Route::post('donatur/truncate', [DonaturController::class, 'truncate'])->name('donatur.truncate');
        Route::post('donatur/import', [ImportController::class, 'donatur'])->name('donatur.import');
        Route::post('donatur/recalculate', [DonaturController::class, 'recalculate'])->name('donatur.recalculate');
        Route::get('donatur/export/excel', [ExportController::class, 'donaturExcel'])->name('donatur.export.excel');
        Route::get('donatur/export/pdf', [DonaturController::class, 'exportPdf'])->name('donatur.export.pdf');
        Route::get('donatur/{kode_donatur}/struk', [DonaturController::class, 'struk'])->name('donatur.struk');
        Route::get('donatur/{kode_donatur}/print', [DonaturController::class, 'print'])->name('donatur.print');
        Route::get('donatur/{kode_donatur}/pdf', [DonaturController::class, 'exportPdfDetail'])->name('donatur.pdf');

        // Karyawan - Lengkap
        Route::resource('karyawan', KaryawanController::class)->except(['show']);
        Route::get('karyawan/trash', [KaryawanController::class, 'trash'])->name('karyawan.trash');
        Route::patch('karyawan/restore/{nip}', [KaryawanController::class, 'restore'])->name('karyawan.restore');
        Route::delete('karyawan/force-delete/{nip}', [KaryawanController::class, 'forceDelete'])->name('karyawan.forceDelete');
        Route::delete('karyawan/force-delete-all', [KaryawanController::class, 'forceDeleteAll'])->name('karyawan.force-delete-all');
        Route::post('karyawan/truncate', [KaryawanController::class, 'truncate'])->name('karyawan.truncate');
        Route::post('karyawan/import', [ImportController::class, 'karyawan'])->name('karyawan.import');
        Route::get('karyawan/{nip}/slip', [KaryawanController::class, 'slip'])->name('karyawan.slip');
        Route::get('karyawan/export/excel', [ExportController::class, 'karyawanExcel'])->name('karyawan.export.excel');
        
        // Anak Panti
        Route::resource('anak-panti', AnakPantiController::class)->except(['show']);
        Route::post('anak-panti/import', [AnakPantiController::class, 'import'])->name('anak-panti.import');
        Route::post('anak-panti/truncate', [AnakPantiController::class, 'truncate'])->name('anak-panti.truncate');

        // Penerimaan Donasi - Admin full access
        Route::resource('penerimaan-donasi', PenerimaanDonasiController::class)->except(['show']);
        Route::get('penerimaan-donasi/{id}/struk', [PenerimaanDonasiController::class, 'struk'])->name('penerimaan-donasi.struk');
        Route::get('penerimaan-donasi/export/pdf', [PenerimaanDonasiController::class, 'exportPdf'])->name('penerimaan-donasi.export.pdf');
        Route::get('penerimaan-donasi/export/excel', [PenerimaanDonasiController::class, 'exportExcel'])->name('penerimaan-donasi.export.excel');

        // Pengeluaran
        Route::resource('pengeluaran', PengeluaranController::class)->except(['show']);
        Route::get('pengeluaran/export/excel', [PengeluaranController::class, 'exportExcel'])->name('pengeluaran.export.excel');
        Route::get('pengeluaran/export/pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export.pdf');
        Route::get('pengeluaran/export/excel/per-akun/{kode_akun}', [PengeluaranController::class, 'exportExcelPerAkun'])->name('pengeluaran.export.excel.per-akun');
        Route::get('pengeluaran/export/pdf/per-akun/{kode_akun}', [PengeluaranController::class, 'exportPdfPerAkun'])->name('pengeluaran.export.pdf.per-akun');


        // Jurnal Umum
        Route::resource('jurnal-umum', JurnalUmumController::class)->except(['show']);
        Route::get('jurnal-umum/export/pdf',   [JurnalUmumController::class, 'exportPdf'])->name('jurnal-umum.export.pdf');
        Route::get('jurnal-umum/export/excel', [JurnalUmumController::class, 'exportExcel'])->name('jurnal-umum.export.excel');

        // Daftar Akun & Saldo Awal
        Route::resource('daftar-akun', DaftarAkunController::class)->except(['show']);
        Route::resource('saldo-awal', SaldoAwalController::class)->only(['index', 'store']);
        Route::get('saldo-awal/export/all', [SaldoAwalController::class, 'exportAll'])->name('saldo-awal.export.all');
        Route::post('saldo-awal/export/kelompok', [SaldoAwalController::class, 'exportKelompok'])->name('saldo-awal.export.kelompok');
        Route::get('saldo-awal/export/pdf', [SaldoAwalController::class, 'exportPdf'])->name('saldo-awal.pdf');

        // Barang & Persediaan
        Route::resource('barang', BarangController::class);
        Route::resource('persediaan-masuk', PersediaanMasukController::class);
        Route::get('persediaan-keluar/{id}/print', [PersediaanKeluarController::class, 'print'])->name('persediaan-keluar.print');
        Route::resource('penjualan-pemakaian-barang', PersediaanKeluarController::class)->except(['show']);

        // Aset Tetap & Iventaris
        Route::resource('aset-tetap', AsetTetapController::class)->except(['show']);
        // Penyusutan Aset Tetap
        Route::get('penyusutan', [PenyusutanController::class, 'index'])->name('penyusutan.index');
        Route::post('penyusutan', [PenyusutanController::class, 'store'])->name('penyusutan.store');
        Route::resource('inventaris', InventarisController::class)->except(['show']);

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/neraca-saldo-penutupan', [LaporanController::class, 'neracaSaldoSetelahPenutupan'])->name('laporan.neraca-saldo-penutupan');
        Route::get('laporan/export/pdf', [ExportController::class, 'laporanPdf'])->name('laporan.pdf');
        Route::get('laporan/export/excel', [ExportController::class, 'laporanExcel'])->name('laporan.excel');

        // Buku Besar
        Route::get('buku-besar', [BukuBesarController::class, 'index'])->name('buku-besar.index');
        Route::get('buku-besar/pdf', [BukuBesarController::class, 'exportPdf'])->name('buku-besar.pdf');
        Route::get('buku-besar/excel', [BukuBesarController::class, 'exportExcel'])->name('buku-besar.excel');

        // Arus Kas
        Route::get('arus-kas', [ArusKasController::class, 'index'])->name('arus-kas.index');
        Route::get('arus-kas/pdf', [ArusKasController::class, 'exportPdf'])->name('arus-kas.pdf');

        // Tutup Buku
        Route::get('tutup-buku', [TutupBukuController::class, 'index'])->name('tutup-buku.index');
        Route::post('tutup-buku', [TutupBukuController::class, 'store'])->name('tutup-buku.store');

        // Identitas Panti
        Route::get('identitas-panti/edit', [IdentitasPantiController::class, 'edit'])->name('identitas-panti.edit');
        Route::put('identitas-panti', [IdentitasPantiController::class, 'update'])->name('identitas-panti.update');

        // Audit Log
        Route::get('audit-log', [AuditLogController::class, 'index'])->name('audit-log.index');

        // Profile & Staff
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::resource('staff', StaffController::class)->except(['show']);

        //Kas Besar
        Route::get('kas-besar/export/excel', [App\Http\Controllers\Admin\KasBesarController::class, 'exportExcel'])->name('kas-besar.export.excel');
        Route::resource('kas-besar', App\Http\Controllers\Admin\KasBesarController::class)->except(['show']);
        Route::post('kas-besar', [App\Http\Controllers\Admin\KasBesarController::class, 'destroy'])->name('admin.kas-besar.destroy');
        Route::post('kas-besar', [App\Http\Controllers\Admin\KasBesarController::class, 'store'])->name('admin.kas-besar.store');
        Route::get('kas-besar/{id}/print', [App\Http\Controllers\Admin\KasBesarController::class, 'struk'])->name('kas-besar.print');

        //Kas Kecil
        Route::resource('kas-kecil', KasKecilController::class)->except(['show']);
        Route::get('kas-kecil/export/excel', [KasKecilController::class, 'exportExcel'])->name('kas-kecil.export.excel');
        Route::post('kas-kecil', [KasKecilController::class, 'destroy'])->name('admin.kas-kecil.destroy');
        Route::post('kas-kecil', [KasKecilController::class, 'store'])->name('admin.kas-kecil.store');
        Route::get('kas-kecil/{id}/print', [KasKecilController::class, 'struk'])->name('kas-kecil.print');

        // Test Kop Surat
        Route::get('/test-kop', function () {
            return view('admin.components.kop-surat');
        });
    });

// ====================== STAFF AREA ======================
Route::prefix('staff')
    ->middleware(['auth', 'role:staff'])
    ->as('staff.')
    ->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // Penerimaan Donasi - Staff hanya create & store + cetak struk
        Route::get('penerimaan-donasi/create', [StaffPenerimaanDonasiController::class, 'create'])
            ->name('penerimaan-donasi.create');
        Route::post('penerimaan-donasi', [StaffPenerimaanDonasiController::class, 'store'])
            ->name('penerimaan-donasi.store');
        Route::get('penerimaan-donasi/{id}/struk', [PenerimaanDonasiController::class, 'struk'])
            ->name('penerimaan-donasi.struk');

        // Pengeluaran - Staff hanya create & store
        Route::get('pengeluaran/create', [StaffPengeluaranController::class, 'create'])
            ->name('pengeluaran.create');
        Route::post('pengeluaran', [StaffPengeluaranController::class, 'store'])
            ->name('pengeluaran.store');

        // Jurnal Umum (read-only untuk staff)
        Route::get('jurnal-umum', [JurnalUmumController::class, 'index'])
            ->name('jurnal-umum.index');
    });

// ====================== AUTHENTICATION ROUTES ======================
require __DIR__ . '/auth.php';

// ====================== WELCOME / LANDING PAGE ======================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');