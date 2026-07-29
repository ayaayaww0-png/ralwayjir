<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris_ruangans', function (Blueprint $table) {
            $table->id('id_inventaris');
            $table->foreignId('id_supplier')->constrained('suppliers', 'id_supplier')->onDelete('cascade');
            $table->foreignId('id_barang')->constrained('barangs', 'id_barang')->onDelete('cascade');
            $table->foreignId('id_ruangan')->constrained('ruangans', 'id_ruangan')->onDelete('cascade');
            $table->enum('kondisi', ['BAIK', 'RUSAK', 'HILANG'])->default('BAIK');
            $table->integer('stok')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris_ruangans');
    }
};