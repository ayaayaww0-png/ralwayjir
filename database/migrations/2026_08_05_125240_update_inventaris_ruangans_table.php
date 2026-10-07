<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris_ruangans', function (Blueprint $table) {
            // Hapus kolom yang tidak dipakai
            $table->dropForeign(['id_supplier']);
            $table->dropColumn(['id_supplier', 'stok', 'kondisi']);

            // Tambah kolom baru
            $table->integer('stok_baik')->unsigned()->default(0)->after('id_ruangan');
            $table->integer('stok_rusak')->unsigned()->default(0)->after('stok_baik');
            $table->integer('stok_hilang')->unsigned()->default(0)->after('stok_rusak');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris_ruangans', function (Blueprint $table) {
            $table->dropColumn(['stok_baik', 'stok_rusak', 'stok_hilang']);
            $table->foreignId('id_supplier')->constrained('suppliers')->onDelete('cascade');
            $table->integer('stok')->unsigned()->default(0);
            $table->enum('kondisi', ['BAIK', 'RUSAK', 'HILANG'])->default('BAIK');
        });
    }
};