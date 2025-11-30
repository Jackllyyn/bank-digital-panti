<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\ProfileController;

// Route khusus untuk redirect setelah login (ini yang dipakai Breeze)
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('staff.dashboard');
})->middleware('auth')->name('dashboard');   // ← INI YANG DIPERLUKAN!

// ADMIN AREA
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('donatur', DonaturController::class)->except(['show']);
        // tambah route trash & restore
        Route::get('donatur-trash', [DonaturController::class, 'trash'])->name('donatur.trash');
        Route::post('donatur/{kode_donatur}/restore', [DonaturController::class, 'restore'])->name('donatur.restore');
        Route::delete('donatur/{kode_donatur}/force', [DonaturController::class, 'forceDelete'])->name('donatur.force');
    });
    

// STAFF AREA
Route::prefix('staff')
    ->middleware(['auth', 'role:staff'])
    ->as('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');
    });


    
// Auth routes dari Breeze (login, register, logout, dll)
require __DIR__.'/auth.php';

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});