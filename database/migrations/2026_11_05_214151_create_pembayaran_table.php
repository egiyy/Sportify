<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
