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
        if (!Schema::hasTable('penukaran')) {
            Schema::create('penukaran', function (Blueprint $table) {
                $table->id('id_penukaran');
                $table->foreignId('id_customer')->constrained('customer', 'id_customer')->cascadeOnDelete();
                $table->foreignId('id_reward')->constrained('reward', 'id_reward')->cascadeOnDelete();
                $table->timestamp('tanggal_tukar')->useCurrent();
                $table->string('status_penukaran', 20)->default('selesai'); // selesai, diproses, ditolak
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penukaran');
    }
};
