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
        if (!Schema::hasTable('point')) {
            Schema::create('point', function (Blueprint $table) {
                $table->id('id_point');
                $table->foreignId('id_customer')->constrained('customer', 'id_customer')->cascadeOnDelete();
                $table->integer('jumlah_point');
                $table->text('riwayat_transaksi');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point');
    }
};
