<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot', function (Blueprint $table) {
            $table->id('id_slot');
            $table->foreignId('id_lapangan')->constrained('lapangan', 'id_lapangan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('status_slot', 20)->default('tersedia');
            $table->timestamps();

            // Constraint unik mencegah jadwal jam ganda di lapangan yang sama
            $table->unique(['id_lapangan', 'tanggal', 'jam_mulai'], 'slot_unique_jam');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot');
    }
};