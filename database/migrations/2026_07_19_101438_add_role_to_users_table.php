<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['ADMIN', 'PETUGAS', 'KEPALA_SEKOLAH'])->default('PETUGAS');
            $table->string('username')->unique()->after('id');
            // Hapus baris ini karena email sudah unique dari bawaan Laravel
            // $table->string('email')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'username']);
        });
    }
};