<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data dengan cara manual (pakai delete, bukan truncate)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Kategori::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $kategoris = [
            'KIB A (Tanah)',
            'KIB B (Peralatan & Mesin)',
            'KIB C (Gedung & Bangunan)',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create(['nama_kategori' => $nama]);
        }

        $this->command->info('✅ Kategori berhasil diisi!');
    }
}