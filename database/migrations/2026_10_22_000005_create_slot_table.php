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
        if (!Schema::hasTable('slot')) {
            Schema::create('slot', function (Blueprint $table) {
                $table->id('id_slot');
                $table->foreignId('id_lapangan')->constrained('lapangan', 'id_lapangan')->cascadeOnDelete();
                $table->date('tanggal');
                $table->time('jam_mulai');
                $table->time('jam_selesai');
                $table->string('status_slot', 20)->default('tersedia'); // tersedia, dibooking
                $table->timestamps();

                // Constraint to prevent double booking on same field, date, and start time
                $table->unique(['id_lapangan', 'tanggal', 'jam_mulai'], 'slot_lapangan_waktu_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot');
    }
};
