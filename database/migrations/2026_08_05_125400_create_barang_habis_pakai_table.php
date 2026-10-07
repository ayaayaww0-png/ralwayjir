<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_habis_pakai', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('nama_barang', 100);
            $table->integer('sisa_awal')->default(0);

            // 12 bulan × 4 kolom
            $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
            foreach ($months as $month) {
                $table->integer($month . '_m')->default(0);  // Masuk
                $table->integer($month . '_k')->default(0);  // Keluar
                $table->integer($month . '_jml')->default(0); // Jumlah
                $table->integer($month . '_sisa')->default(0); // Sisa
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_habis_pakai');
    }
};