<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris_ruangans', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('inventaris_ruangans', 'id_supplier')) {
                try {
                    $table->dropForeign(['id_supplier']);
                } catch (\Exception $e) {}
                $table->dropColumn('id_supplier');
            }

            if (Schema::hasColumn('inventaris_ruangans', 'stok')) {
                $table->dropColumn('stok');
            }

            if (Schema::hasColumn('inventaris_ruangans', 'kondisi')) {
                $table->dropColumn('kondisi');
            }

            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('inventaris_ruangans', 'stok_baik')) {
                $table->integer('stok_baik')->unsigned()->default(0)->after('id_ruangan');
            }
            if (!Schema::hasColumn('inventaris_ruangans', 'stok_rusak')) {
                $table->integer('stok_rusak')->unsigned()->default(0)->after('stok_baik');
            }
            if (!Schema::hasColumn('inventaris_ruangans', 'stok_hilang')) {
                $table->integer('stok_hilang')->unsigned()->default(0)->after('stok_rusak');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventaris_ruangans', function (Blueprint $table) {
            $table->dropColumn(['stok_baik', 'stok_rusak', 'stok_hilang']);
            $table->foreignId('id_supplier')->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->integer('stok')->unsigned()->default(0);
            $table->enum('kondisi', ['BAIK', 'RUSAK', 'HILANG'])->default('BAIK');
        });
    }
};