<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Ruangan;
use App\Models\Barang;
use App\Models\InventarisRuangan;
use App\Models\BarangMasuk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS atau COMMENT baris ini:
        // $this->call(UserSeeder::class);
        
        // 1. Buat Kategori
        $kategori1 = Kategori::create(['nama_kategori' => 'ATK (Alat Tulis Kantor)']);
        $kategori2 = Kategori::create(['nama_kategori' => 'Elektronik']);
        $kategori3 = Kategori::create(['nama_kategori' => 'Furniture']);
        $kategori4 = Kategori::create(['nama_kategori' => 'Peralatan Lab']);
        $kategori5 = Kategori::create(['nama_kategori' => 'Olahraga']);
        $kategori6 = Kategori::create(['nama_kategori' => 'Kendaraan']);

        // 2. Buat Supplier
        $supplier1 = Supplier::create(['nama_supplier' => 'Toko ATK Maju']);
        $supplier2 = Supplier::create(['nama_supplier' => 'CV Elektronik Jaya']);
        $supplier3 = Supplier::create(['nama_supplier' => 'PT Furniture Sentosa']);
        $supplier4 = Supplier::create(['nama_supplier' => 'Lab Sains Indonesia']);
        $supplier5 = Supplier::create(['nama_supplier' => 'Sport Center']);

        // 3. Buat Ruangan
        $ruangan1 = Ruangan::create(['nama_ruangan' => 'Ruang Kelas 1A']);
        $ruangan2 = Ruangan::create(['nama_ruangan' => 'Ruang Kelas 1B']);
        $ruangan3 = Ruangan::create(['nama_ruangan' => 'Ruang Kelas 2A']);
        $ruangan4 = Ruangan::create(['nama_ruangan' => 'Ruang Kelas 2B']);
        $ruangan5 = Ruangan::create(['nama_ruangan' => 'Laboratorium Komputer']);
        $ruangan6 = Ruangan::create(['nama_ruangan' => 'Laboratorium IPA']);
        $ruangan7 = Ruangan::create(['nama_ruangan' => 'Perpustakaan']);
        $ruangan8 = Ruangan::create(['nama_ruangan' => 'Kantor Guru']);
        $ruangan9 = Ruangan::create(['nama_ruangan' => 'Kepala Sekolah']);
        $ruangan10 = Ruangan::create(['nama_ruangan' => 'Gudang']);

        // 4. Buat Barang dengan stok awal
        $barang1 = Barang::create([
            'kode_barang' => 'ATK-001',
            'nama_barang' => 'Buku Tulis',
            'id_kategori' => $kategori1->id_kategori,
            'stok_total' => 150,
            'min_stok' => 20
        ]);

        $barang2 = Barang::create([
            'kode_barang' => 'ATK-002',
            'nama_barang' => 'Pulpen',
            'id_kategori' => $kategori1->id_kategori,
            'stok_total' => 200,
            'min_stok' => 30
        ]);

        $barang3 = Barang::create([
            'kode_barang' => 'ATK-003',
            'nama_barang' => 'Pensil',
            'id_kategori' => $kategori1->id_kategori,
            'stok_total' => 150,
            'min_stok' => 25
        ]);

        $barang4 = Barang::create([
            'kode_barang' => 'ATK-004',
            'nama_barang' => 'Penghapus',
            'id_kategori' => $kategori1->id_kategori,
            'stok_total' => 80,
            'min_stok' => 10
        ]);

        $barang5 = Barang::create([
            'kode_barang' => 'ELEK-001',
            'nama_barang' => 'Laptop Asus',
            'id_kategori' => $kategori2->id_kategori,
            'stok_total' => 25,
            'min_stok' => 5
        ]);

        $barang6 = Barang::create([
            'kode_barang' => 'ELEK-002',
            'nama_barang' => 'Proyektor',
            'id_kategori' => $kategori2->id_kategori,
            'stok_total' => 8,
            'min_stok' => 2
        ]);

        $barang7 = Barang::create([
            'kode_barang' => 'ELEK-003',
            'nama_barang' => 'Monitor LCD',
            'id_kategori' => $kategori2->id_kategori,
            'stok_total' => 15,
            'min_stok' => 3
        ]);

        $barang8 = Barang::create([
            'kode_barang' => 'ELEK-004',
            'nama_barang' => 'Printer',
            'id_kategori' => $kategori2->id_kategori,
            'stok_total' => 10,
            'min_stok' => 2
        ]);

        $barang9 = Barang::create([
            'kode_barang' => 'FURN-001',
            'nama_barang' => 'Meja Kayu',
            'id_kategori' => $kategori3->id_kategori,
            'stok_total' => 50,
            'min_stok' => 10
        ]);

        $barang10 = Barang::create([
            'kode_barang' => 'FURN-002',
            'nama_barang' => 'Kursi',
            'id_kategori' => $kategori3->id_kategori,
            'stok_total' => 100,
            'min_stok' => 20
        ]);

        $barang11 = Barang::create([
            'kode_barang' => 'FURN-003',
            'nama_barang' => 'Lemari',
            'id_kategori' => $kategori3->id_kategori,
            'stok_total' => 30,
            'min_stok' => 5
        ]);

        $barang12 = Barang::create([
            'kode_barang' => 'FURN-004',
            'nama_barang' => 'Rak Buku',
            'id_kategori' => $kategori3->id_kategori,
            'stok_total' => 20,
            'min_stok' => 5
        ]);

        $barang13 = Barang::create([
            'kode_barang' => 'LAB-001',
            'nama_barang' => 'Mikroskop',
            'id_kategori' => $kategori4->id_kategori,
            'stok_total' => 12,
            'min_stok' => 3
        ]);

        $barang14 = Barang::create([
            'kode_barang' => 'LAB-002',
            'nama_barang' => 'Tabung Reaksi',
            'id_kategori' => $kategori4->id_kategori,
            'stok_total' => 50,
            'min_stok' => 10
        ]);

        $barang15 = Barang::create([
            'kode_barang' => 'LAB-003',
            'nama_barang' => 'Timbangan Digital',
            'id_kategori' => $kategori4->id_kategori,
            'stok_total' => 8,
            'min_stok' => 2
        ]);

        $barang16 = Barang::create([
            'kode_barang' => 'OLR-001',
            'nama_barang' => 'Bola Basket',
            'id_kategori' => $kategori5->id_kategori,
            'stok_total' => 20,
            'min_stok' => 5
        ]);

        $barang17 = Barang::create([
            'kode_barang' => 'OLR-002',
            'nama_barang' => 'Bola Voli',
            'id_kategori' => $kategori5->id_kategori,
            'stok_total' => 15,
            'min_stok' => 4
        ]);

        $barang18 = Barang::create([
            'kode_barang' => 'OLR-003',
            'nama_barang' => 'Raket Badminton',
            'id_kategori' => $kategori5->id_kategori,
            'stok_total' => 30,
            'min_stok' => 8
        ]);

        $barang19 = Barang::create([
            'kode_barang' => 'KND-001',
            'nama_barang' => 'Sepeda Motor',
            'id_kategori' => $kategori6->id_kategori,
            'stok_total' => 3,
            'min_stok' => 1
        ]);

        $barang20 = Barang::create([
            'kode_barang' => 'KND-002',
            'nama_barang' => 'Mobil Operasional',
            'id_kategori' => $kategori6->id_kategori,
            'stok_total' => 2,
            'min_stok' => 1
        ]);

        // 5. Buat Inventaris Ruangan
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang1->id_barang,
            'id_ruangan' => $ruangan1->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 30
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang1->id_barang,
            'id_ruangan' => $ruangan2->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 25
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang1->id_barang,
            'id_ruangan' => $ruangan7->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 50
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang2->id_barang,
            'id_ruangan' => $ruangan1->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 50
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang2->id_barang,
            'id_ruangan' => $ruangan2->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 40
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier1->id_supplier,
            'id_barang' => $barang2->id_barang,
            'id_ruangan' => $ruangan3->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 30
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier2->id_supplier,
            'id_barang' => $barang5->id_barang,
            'id_ruangan' => $ruangan5->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 15
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier2->id_supplier,
            'id_barang' => $barang5->id_barang,
            'id_ruangan' => $ruangan8->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 5
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier2->id_supplier,
            'id_barang' => $barang5->id_barang,
            'id_ruangan' => $ruangan9->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 3
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier2->id_supplier,
            'id_barang' => $barang6->id_barang,
            'id_ruangan' => $ruangan5->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 3
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier2->id_supplier,
            'id_barang' => $barang6->id_barang,
            'id_ruangan' => $ruangan8->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 2
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier3->id_supplier,
            'id_barang' => $barang9->id_barang,
            'id_ruangan' => $ruangan1->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 15
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier3->id_supplier,
            'id_barang' => $barang9->id_barang,
            'id_ruangan' => $ruangan8->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 10
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier3->id_supplier,
            'id_barang' => $barang10->id_barang,
            'id_ruangan' => $ruangan1->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 30
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier3->id_supplier,
            'id_barang' => $barang10->id_barang,
            'id_ruangan' => $ruangan2->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 25
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier4->id_supplier,
            'id_barang' => $barang13->id_barang,
            'id_ruangan' => $ruangan6->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 10
        ]);
        InventarisRuangan::create([
            'id_supplier' => $supplier5->id_supplier,
            'id_barang' => $barang16->id_barang,
            'id_ruangan' => $ruangan10->id_ruangan,
            'kondisi' => 'BAIK',
            'stok' => 15
        ]);

        // 6. Buat transaksi Barang Masuk
        BarangMasuk::create([
            'tanggal' => Carbon::now()->subDays(10),
            'id_barang' => $barang1->id_barang,
            'id_supplier' => $supplier1->id_supplier,
            'id_ruangan' => $ruangan7->id_ruangan,
            'jumlah' => 100
        ]);
        BarangMasuk::create([
            'tanggal' => Carbon::now()->subDays(7),
            'id_barang' => $barang2->id_barang,
            'id_supplier' => $supplier1->id_supplier,
            'id_ruangan' => $ruangan1->id_ruangan,
            'jumlah' => 150
        ]);
        BarangMasuk::create([
            'tanggal' => Carbon::now()->subDays(5),
            'id_barang' => $barang5->id_barang,
            'id_supplier' => $supplier2->id_supplier,
            'id_ruangan' => $ruangan5->id_ruangan,
            'jumlah' => 20
        ]);
        BarangMasuk::create([
            'tanggal' => Carbon::now()->subDays(3),
            'id_barang' => $barang9->id_barang,
            'id_supplier' => $supplier3->id_supplier,
            'id_ruangan' => $ruangan8->id_ruangan,
            'jumlah' => 30
        ]);
        BarangMasuk::create([
            'tanggal' => Carbon::now()->subDays(2),
            'id_barang' => $barang13->id_barang,
            'id_supplier' => $supplier4->id_supplier,
            'id_ruangan' => $ruangan6->id_ruangan,
            'jumlah' => 10
        ]);

        echo "========================================\n";
        echo "✅ SEEDER BERHASIL!\n";
        echo "========================================\n";
        echo "📊 Data yang diisi:\n";
        echo "- " . Kategori::count() . " Kategori\n";
        echo "- " . Supplier::count() . " Supplier\n";
        echo "- " . Ruangan::count() . " Ruangan\n";
        echo "- " . Barang::count() . " Barang\n";
        echo "- " . InventarisRuangan::count() . " Inventaris Ruangan\n";
        echo "- " . BarangMasuk::count() . " Transaksi Masuk\n";
        echo "========================================\n";
    }
}