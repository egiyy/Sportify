<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
Route::get('/', function () {
    
    return view('welcome');
});


