<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PemilikController;

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
Route::get('/', function () {
    
    return view('welcome');
});

// Pemilik Lapangan Portal
Route::prefix('pemilik')->name('pemilik.')->middleware(['sportify.auth:pemilik'])->group(function () {
    Route::get('/dashboard', [PemilikController::class, 'dashboard'])->name('dashboard');
    
    // Lapangan CRUD
    Route::get('/lapangan', [PemilikController::class, 'lapanganIndex'])->name('lapangan.index');
    Route::get('/lapangan/create', [PemilikController::class, 'lapanganCreate'])->name('lapangan.create');
    Route::post('/lapangan', [PemilikController::class, 'lapanganStore'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [PemilikController::class, 'lapanganEdit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [PemilikController::class, 'lapanganUpdate'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [PemilikController::class, 'lapanganDestroy'])->name('lapangan.destroy');

    // Slots Management
    Route::get('/slots', [PemilikController::class, 'slotIndex'])->name('slots');
    Route::post('/slots', [PemilikController::class, 'slotStore'])->name('slot.store');
    Route::delete('/slots/{id}', [PemilikController::class, 'slotDestroy'])->name('slot.destroy');
});

