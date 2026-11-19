<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\AdminController;

// Beranda Sportify
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Detail Lapangan
Route::get('/lapangan/{id}', [HomeController::class, 'lapanganDetail'])
    ->name('lapangan.detail');

// Refresh status slot lapangan
Route::get('/lapangan/{id}/slots', [HomeController::class, 'getSlots'])
    ->name('lapangan.slots');

// Halaman Reward
Route::get('/rewards', [RewardController::class, 'index'])
    ->name('rewards.index');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])
    ->name('demo.login');

// Booking Customer
Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/my-bookings', [BookingController::class, 'myBookings'])
    ->middleware('sportify.auth:customer')
    ->name('customer.bookings');

// Invoice Booking
Route::get('/booking/{id}/invoice', [BookingController::class, 'invoice'])
    ->name('booking.invoice');

// Pembatalan Booking
Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])
    ->name('booking.cancel');

// Ulasan Customer
Route::post('/ulasan', [UlasanController::class, 'store'])
    ->middleware('sportify.auth:customer')
    ->name('ulasan.store');

// Portal Pemilik Lapangan
Route::prefix('pemilik')
    ->name('pemilik.')
    ->middleware(['sportify.auth:pemilik'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PemilikController::class, 'dashboard'])
            ->name('dashboard');

        // Lapangan CRUD
        Route::get('/lapangan', [PemilikController::class, 'lapanganIndex'])
            ->name('lapangan.index');

        Route::get('/lapangan/create', [PemilikController::class, 'lapanganCreate'])
            ->name('lapangan.create');

        Route::post('/lapangan', [PemilikController::class, 'lapanganStore'])
            ->name('lapangan.store');

        Route::get('/lapangan/{id}/edit', [PemilikController::class, 'lapanganEdit'])
            ->name('lapangan.edit');

        Route::put('/lapangan/{id}', [PemilikController::class, 'lapanganUpdate'])
            ->name('lapangan.update');

        Route::delete('/lapangan/{id}', [PemilikController::class, 'lapanganDestroy'])
            ->name('lapangan.destroy');

        // Manajemen Slot
        Route::get('/slots', [PemilikController::class, 'slotIndex'])
            ->name('slots');

        Route::post('/slots', [PemilikController::class, 'slotStore'])
            ->name('slot.store');

        Route::delete('/slots/{id}', [PemilikController::class, 'slotDestroy'])
            ->name('slot.destroy');

        // Booking dan Verifikasi Pembayaran
        Route::get('/bookings', [PemilikController::class, 'bookingIndex'])
            ->name('bookings');

        Route::post('/bookings/{id}/verify', [PemilikController::class, 'bookingVerifyPayment'])
            ->name('booking.verify');

        Route::post('/bookings/{id}/complete', [PemilikController::class, 'bookingComplete'])
            ->name('booking.complete');

        // Ulasan Pemilik
        Route::get('/ulasan', [PemilikController::class, 'ulasanIndex'])
            ->name('ulasan.index');

        Route::post('/ulasan/{id}/reply', [UlasanController::class, 'reply'])
            ->name('ulasan.reply');
    });

// Portal Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['sportify.auth:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Monitoring dan Verifikasi Lapangan
        Route::get('/lapangan', [AdminController::class, 'lapanganIndex'])
            ->name('lapangan');

        Route::post('/lapangan/{id}/verify', [AdminController::class, 'verifyLapangan'])
            ->name('lapangan.verify');

        // Verifikasi Pemilik
        Route::get('/pemilik', [AdminController::class, 'pemilikIndex'])
            ->name('pemilik');

        Route::post('/pemilik/{id}/verify', [AdminController::class, 'verifyPemilik'])
            ->name('pemilik.verify');

        // Monitoring Booking dan Pembayaran
        Route::get('/bookings', [AdminController::class, 'bookingIndex'])
            ->name('bookings');

        Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])
            ->name('pembayaran');

        // Manajemen Reward
        Route::get('/rewards', [AdminController::class, 'rewardIndex'])
            ->name('rewards');

        Route::post('/rewards', [AdminController::class, 'rewardStore'])
            ->name('rewards.store');

        Route::put('/rewards/{id}', [AdminController::class, 'rewardUpdate'])
            ->name('rewards.update');

        Route::delete('/rewards/{id}', [AdminController::class, 'rewardDestroy'])
            ->name('rewards.destroy');
    });

// Tentang / Tim Pengembang
Route::get('/about', [HomeController::class, 'about'])
    ->name('about');
