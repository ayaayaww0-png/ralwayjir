<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            // Ubah id_ruangan menjadi nullable
            $table->foreignId('id_ruangan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->foreignId('id_ruangan')->nullable(false)->change();
        });
    }
};