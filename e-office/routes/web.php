<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KabidController;
use App\Http\Controllers\SuratController;

Route::middleware(['auth'])->group(function () {
    Route::get('/kabid/dashboard', [KabidController::class, 'index'])
        ->name('kabid.dashboard');
    Route::get('/surat/{id}/download', [SuratController::class, 'download'])
        ->name('surat.download');
    Route::resource('surat', SuratController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'index']);
     Route::resource('user', UserController::class);
     Route::resource('bidang', BidangController::class);
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
