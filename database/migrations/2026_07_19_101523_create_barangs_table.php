<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('kode_barang', 15)->unique();
            $table->string('nama_barang', 50);
            $table->foreignId('id_kategori')->constrained('kategoris', 'id_kategori')->onDelete('cascade');
            $table->integer('stok_total')->unsigned()->default(0);
            $table->integer('min_stok')->unsigned()->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};