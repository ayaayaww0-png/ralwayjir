<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris_ruangans', function (Blueprint $table) {
            // Cek dan hapus foreign key jika ada
            $foreignKeys = $this->getForeignKeys('inventaris_ruangans');
            if (in_array('inventaris_ruangans_id_supplier_foreign', $foreignKeys)) {
                $table->dropForeign('inventaris_ruangans_id_supplier_foreign');
            }

            // Hapus kolom id_supplier jika ada
            if (Schema::hasColumn('inventaris_ruangans', 'id_supplier')) {
                $table->dropColumn('id_supplier');
            }

            // Hapus kolom stok jika ada
            if (Schema::hasColumn('inventaris_ruangans', 'stok')) {
                $table->dropColumn('stok');
            }

            // Hapus kolom kondisi jika ada
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
            
            // Tambah kembali kolom lama
            $table->foreignId('id_supplier')->nullable()->constrained('suppliers', 'id_supplier')->onDelete('cascade');
            $table->integer('stok')->unsigned()->default(0);
            $table->enum('kondisi', ['BAIK', 'RUSAK', 'HILANG'])->default('BAIK');
        });
    }

    private function getForeignKeys($table)
    {
        $conn = Schema::getConnection();

        $data = $conn->select(
            "SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = ? 
            AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$conn->getDatabaseName(), $table]
        );

        return collect($data)->pluck('CONSTRAINT_NAME')->toArray();
    }
};