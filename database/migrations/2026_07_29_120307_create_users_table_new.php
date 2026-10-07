<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus dulu tabel users kalau ada
        Schema::dropIfExists('users');

        // Buat ulang tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('nis', 20)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'kepsek'])->default('guru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};