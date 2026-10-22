<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\AdminController;

// Existing practical controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataKuliahController;

/*
|--------------------------------------------------------------------------
| SPORTIFY - Main Application Routes
| Sistem Pemesanan Lapangan Futsal & Olahraga Terpadu
|--------------------------------------------------------------------------
*/

// Public & Customer Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lapangan/{id}', [HomeController::class, 'lapanganDetail'])->name('lapangan.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');

// Customer Actions (Protected by sportify.auth:customer)
Route::middleware(['sportify.auth:customer'])->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('customer.bookings');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::post('/rewards/{id}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

// Printable Invoice (Public for authorized user / owner)
Route::get('/invoice/{id}', [PembayaranController::class, 'invoice'])->name('booking.invoice');

// Pemilik Lapangan Portal
Route::prefix('pemilik')->name('pemilik.')->middleware(['sportify.auth:pemilik'])->group(function () {
    Route::get('/dashboard', [PemilikController::class, 'dashboard'])->name('dashboard');
    
    // Lapangan
    Route::get('/lapangan', [PemilikController::class, 'lapanganIndex'])->name('lapangan.index');
    Route::get('/lapangan/create', [PemilikController::class, 'lapanganCreate'])->name('lapangan.create');
    Route::post('/lapangan', [PemilikController::class, 'lapanganStore'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [PemilikController::class, 'lapanganEdit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [PemilikController::class, 'lapanganUpdate'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [PemilikController::class, 'lapanganDestroy'])->name('lapangan.destroy');

    // Slots
    Route::get('/slots', [PemilikController::class, 'slotIndex'])->name('slots');
    Route::post('/slots', [PemilikController::class, 'slotStore'])->name('slot.store');
    Route::delete('/slots/{id}', [PemilikController::class, 'slotDestroy'])->name('slot.destroy');

    // Bookings & Payments
    Route::get('/bookings', [PemilikController::class, 'bookingIndex'])->name('bookings');
    Route::post('/bookings/{id}/verify', [PemilikController::class, 'bookingVerifyPayment'])->name('booking.verify');
    Route::post('/bookings/{id}/complete', [PemilikController::class, 'bookingComplete'])->name('booking.complete');

    // Reviews
    Route::get('/ulasan', [PemilikController::class, 'ulasanIndex'])->name('ulasan');
    Route::post('/ulasan/{id}/reply', [UlasanController::class, 'reply'])->name('ulasan.reply');
});

// Administrator Portal
Route::prefix('admin')->name('admin.')->middleware(['sportify.auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/lapangan', [AdminController::class, 'lapanganIndex'])->name('lapangan');
    Route::post('/lapangan/{id}/verify', [AdminController::class, 'verifyLapangan'])->name('lapangan.verify');
    Route::get('/pemilik', [AdminController::class, 'pemilikIndex'])->name('pemilik');
    Route::post('/pemilik/{id}/verify', [AdminController::class, 'verifyPemilik'])->name('pemilik.verify');
    Route::get('/bookings', [AdminController::class, 'bookingIndex'])->name('bookings');
    Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])->name('pembayaran');
    
    // Rewards
    Route::get('/rewards', [AdminController::class, 'rewardIndex'])->name('rewards');
    Route::post('/rewards', [AdminController::class, 'rewardStore'])->name('reward.store');
    Route::put('/rewards/{id}', [AdminController::class, 'rewardUpdate'])->name('reward.update');
    Route::delete('/rewards/{id}', [AdminController::class, 'rewardDestroy'])->name('reward.destroy');
});

/*
|--------------------------------------------------------------------------
| Previous Course Practicals (Modul 1-6)
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'profile']);
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');

Route::get('/matakuliah', [MataKuliahController::class, 'index']);
Route::get('/matakuliah/create', [MataKuliahController::class, 'create'])->name('matakuliah.create');
Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
Route::get('/matakuliah/{id}/edit', [MataKuliahController::class, 'edit'])->name('matakuliah.edit');
Route::put('/matakuliah/{id}', [MataKuliahController::class, 'update'])->name('matakuliah.update');
Route::delete('/matakuliah/{id}', [MataKuliahController::class, 'destroy'])->name('matakuliah.destroy');