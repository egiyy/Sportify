<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('Asia/Jakarta');
        \Carbon\Carbon::setLocale('id');

        try {
            // Pastikan akun default Administrator selalu tersedia dan aktif
            if (Schema::hasTable('admin')) {
                $admin = \App\Models\Admin::where('email', 'admin@sportify.com')->first();
                if (!$admin) {
                    \App\Models\Admin::create([
                        'nama_admin' => 'Administrator Sportify',
                        'email' => 'admin@sportify.com',
                        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                        'no_wa' => '081234567890',
                    ]);
                } else {
                    $admin->update([
                        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                    ]);
                }
            }

            if (Schema::hasTable('booking')) {
                if (!Schema::hasTable('pembayaran')) {
                    Schema::create('pembayaran', function (Blueprint $table) {
                        $table->id('id_pembayaran');
                        $table->foreignId('id_booking')->unique()->constrained('booking', 'id_booking')->cascadeOnDelete();
                        $table->string('metode_bayar'); // BCA, Mandiri, BRI, QRIS, GoPay, Tunai
                        $table->string('status_bayar', 20)->default('pending'); // pending, lunas, ditolak
                        $table->timestamp('waktu_transaksi')->useCurrent();
                        $table->string('bukti_bayar')->nullable();
                        $table->text('catatan_verifikasi')->nullable();
                        $table->timestamps();
                    });
                }

                if (!Schema::hasTable('ulasan') && Schema::hasTable('customer') && Schema::hasTable('lapangan')) {
                    Schema::create('ulasan', function (Blueprint $table) {
                        $table->id('id_ulasan');
                        $table->foreignId('id_booking')->constrained('booking', 'id_booking')->cascadeOnDelete();
                        $table->foreignId('id_customer')->constrained('customer', 'id_customer')->cascadeOnDelete();
                        $table->foreignId('id_lapangan')->constrained('lapangan', 'id_lapangan')->cascadeOnDelete();
                        $table->integer('rating')->default(5); // 1-5
                        $table->text('komentar');
                        $table->text('balasan_pemilik')->nullable();
                        $table->timestamp('tanggal_balasan')->nullable();
                        $table->timestamps();
                    });
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore if DB connection isn't ready during boot
        }
    }
}

