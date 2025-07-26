<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\LocationController; // <--- TAMBAHKAN INI
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // URL UNTUK MANAJEMEN LOKASI
    Route::resource('locations', LocationController::class); // <--- TAMBAHKAN INI
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    // di dalam Route::middleware('auth')->group(...)
    Route::post('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{item}/return', [ItemController::class, 'returnItem'])->name('items.return'); // <-- TAMBAHKAN INI
    Route::get('/reports/items', [ReportController::class, 'itemReport'])->name('reports.items'); // <-- TAMBAHKAN
    Route::get('/items/{item}/label', [ItemController::class, 'printLabel'])->name('items.label');
    Route::get('/reports/availability', [ReportController::class, 'availability'])->name('reports.availability');
});

require __DIR__ . '/auth.php';
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
