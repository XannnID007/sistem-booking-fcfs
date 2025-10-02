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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->enum('tipe_pembayaran', ['dp', 'lunas', 'pelunasan'])->default('lunas');
            $table->enum('metode_pembayaran', ['qris', 'cash'])->default('qris');
            $table->enum('status_pembayaran', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->string('bukti_transfer', 255)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->foreignId('verifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
