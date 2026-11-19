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
        if (!Schema::hasTable('ulasan')) {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
