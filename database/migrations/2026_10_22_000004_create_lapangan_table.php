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
        if (!Schema::hasTable('lapangan')) {
            Schema::create('lapangan', function (Blueprint $table) {
                $table->id('id_lapangan');
                $table->foreignId('id_pemilik')->constrained('pemilik_lapangan', 'id_pemilik')->cascadeOnDelete();
                $table->foreignId('id_admin')->nullable()->constrained('admin', 'id_admin')->nullOnDelete();
                $table->string('nama_lapangan');
                $table->string('jenis_olahraga', 50)->default('Futsal');
                $table->text('lokasi');
                $table->decimal('harga_per_jam', 10, 2);
                $table->text('deskripsi')->nullable();
                $table->string('foto')->nullable();
                $table->string('status_verifikasi', 20)->default('approved'); // approved, pending, rejected
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
