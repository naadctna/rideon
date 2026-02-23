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
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['pemesanan_id']);
            
            // Rename column
            $table->renameColumn('pemesanan_id', 'penyewaan_id');
            
            // Modify enum values
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'e_wallet', 'instant_payment'])->change();
            $table->enum('status', ['pending', 'success', 'failed', 'berhasil'])->change();
        });

        // Add foreign key constraint back
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreign('penyewaan_id')->references('id')->on('penyewaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['penyewaan_id']);
            
            // Rename column back
            $table->renameColumn('penyewaan_id', 'pemesanan_id');
            
            // Revert enum values
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'e_wallet'])->change();
            $table->enum('status', ['pending', 'success', 'failed'])->change();
        });

        // Add foreign key constraint back
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreign('pemesanan_id')->references('id')->on('penyewaans')->onDelete('cascade');
        });
    }
};
