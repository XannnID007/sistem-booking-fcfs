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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_booking');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->tinyInteger('durasi_jam')->unsigned();
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_booking', ['pending', 'dibayar', 'dibatalkan', 'selesai'])->default('pending');
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Unique constraint untuk FCFS - mencegah double booking
            $table->unique(['studio_id', 'tanggal_booking', 'jam_mulai'], 'unique_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
