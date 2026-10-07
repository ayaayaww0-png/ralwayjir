<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kib_c_gedung', function (Blueprint $table) {
            $table->id('id_gedung');
            $table->foreignId('id_barang')->constrained('barangs', 'id_barang')->onDelete('cascade');
            $table->string('register', 50)->nullable();
            $table->enum('kondisi_bangunan', ['B', 'KB', 'RB'])->nullable();
            $table->enum('bertingkat', ['Ya', 'Tidak'])->nullable();
            $table->enum('beton', ['Ya', 'Tidak'])->nullable();
            $table->decimal('luas_lantai', 15, 2)->default(0);
            $table->year('tahun_pembangunan')->nullable();
            $table->text('lokasi_alamat')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('nomor_dokumen', 50)->nullable();
            $table->decimal('luas_tanah', 15, 2)->default(0);
            $table->string('status_tanah', 50)->nullable();
            $table->string('kode_tanah', 50)->nullable();
            $table->string('asal_usul', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kib_c_gedung');
    }
};