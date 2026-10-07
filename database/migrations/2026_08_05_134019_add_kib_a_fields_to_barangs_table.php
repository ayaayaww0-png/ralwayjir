<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('register', 50)->nullable()->after('harga');
            $table->decimal('luas', 15, 2)->nullable()->after('register');
            $table->year('tahun')->nullable()->after('luas');
            $table->text('lokasi')->nullable()->after('tahun');
            $table->string('status_tanah', 50)->nullable()->after('lokasi');
            $table->string('kode_tanah', 50)->nullable()->after('status_tanah');
            $table->string('asal_usul', 50)->nullable()->after('kode_tanah');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['register', 'luas', 'tahun', 'lokasi', 'status_tanah', 'kode_tanah', 'asal_usul']);
        });
    }
};