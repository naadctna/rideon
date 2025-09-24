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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('penyewaans')->onDelete('cascade');
            $table->decimal('jumlah', 10, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'e_wallet']);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
