<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->date('tanggal');
            $table->foreignId('id_barang')->constrained('barangs', 'id_barang')->onDelete('cascade');
            $table->foreignId('id_ruangan')->constrained('ruangans', 'id_ruangan')->onDelete('cascade');
            $table->integer('jumlah')->unsigned();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};