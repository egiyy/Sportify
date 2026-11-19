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
        if (!Schema::hasTable('reward')) {
            Schema::create('reward', function (Blueprint $table) {
                $table->id('id_reward');
                $table->string('nama_reward');
                $table->integer('poin_dibutuhkan');
                $table->integer('stok')->default(20);
                $table->text('deskripsi')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward');
    }
};
