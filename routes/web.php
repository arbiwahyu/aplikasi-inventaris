<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->name('activity-log.index')
        ->middleware('role:Admin');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute yang bisa diakses semua peran yang sudah login
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}/label', [ItemController::class, 'printLabel'])->name('items.label');
    Route::get('/reports/availability', [ReportController::class, 'availability'])->name('reports.availability');

    // Rute yang memerlukan izin 'borrow items'
    Route::middleware('permission:borrow items')->group(function () {
        Route::post('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
        Route::post('/items/{item}/return', [ItemController::class, 'returnItem'])->name('items.return');
    });

    // Rute yang memerlukan izin 'manage items'
    Route::middleware('permission:manage items')->group(function () {
        Route::resource('locations', LocationController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/reports/items', [ReportController::class, 'itemReport'])->name('reports.items');


        // CRUD untuk Items (kecuali 'index' yang sudah publik di atas)
        Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/items/export', [ItemController::class, 'export'])->name('items.export');
        Route::post('/items/import', [ItemController::class, 'import'])->name('items.import');
        Route::get('/items/import-format', [ItemController::class, 'downloadFormat'])->name('items.import-format');
    });

    // Rute untuk manajemen user, hanya untuk Admin
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__ . '/auth.php';
