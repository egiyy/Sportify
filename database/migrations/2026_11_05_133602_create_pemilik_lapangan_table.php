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
        Schema::create('pemilik_lapangan', function (Blueprint $table) {
            $table->id('id_pemilik');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_wa', 15)->nullable();
            $table->string('status_verifikasi', 20)->default('approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemilik_lapangan');
    }
};
