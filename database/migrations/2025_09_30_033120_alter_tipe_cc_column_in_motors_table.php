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
        Schema::table('motors', function (Blueprint $table) {
            // Change tipe_cc from enum to unsigned small integer (supports 0-65535)
            $table->unsignedSmallInteger('tipe_cc')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motors', function (Blueprint $table) {
            // Revert back to enum (for rollback purposes)
            $table->enum('tipe_cc', ['100', '125', '150'])->change();
        });
    }
};
