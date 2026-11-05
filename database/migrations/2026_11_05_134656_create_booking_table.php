<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id('id_booking');
            $table->foreignId('id_customer')->constrained('customer', 'id_customer')->cascadeOnDelete();
            $table->foreignId('id_slot')->unique()->constrained('slot', 'id_slot')->cascadeOnDelete();
            $table->foreignId('id_admin')->nullable()->constrained('admin', 'id_admin')->nullOnDelete();
            $table->timestamp('tanggal_booking')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->string('status_booking', 20)->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};