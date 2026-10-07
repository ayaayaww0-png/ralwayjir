<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalRuangan = Ruangan::count();

        // Barang stok menipis (stok_total <= min_stok)
        $stokMenipis = Barang::whereRaw('stok_total <= min_stok')->get();
        $totalStokMenipis = $stokMenipis->count();

        // 2. STOK PER KATEGORI
        $kategoris = Kategori::with('barang')->get();
        $stokPerKategori = [];
        foreach ($kategoris as $kategori) {
            $totalStok = $kategori->barang->sum('stok_total');
            $stokPerKategori[] = [
                'nama' => $kategori->nama_kategori,
                'total' => $totalStok
            ];
        }

        // 3. KONDISI BARANG (pakai stok_baik, stok_rusak, stok_hilang)
        $kondisiBaik = InventarisRuangan::sum('stok_baik');
        $kondisiRusak = InventarisRuangan::sum('stok_rusak');
        $kondisiHilang = InventarisRuangan::sum('stok_hilang');

        // 4. TRANSAKSI TERBARU (gabungan 3 tabel)
        $barangMasuk = BarangMasuk::with(['barang', 'ruangan', 'supplier'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => '📥 Masuk',
                    'barang' => $item->barang->nama_barang ?? '-',
                    'ruangan' => $item->ruangan->nama_ruangan ?? '-',
                    'supplier' => $item->supplier->nama_supplier ?? '-',
                    'jumlah' => $item->jumlah
                ];
            });

        $barangKeluar = BarangKeluar::with(['barang', 'ruangan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => '📤 Keluar',
                    'barang' => $item->barang->nama_barang ?? '-',
                    'ruangan' => $item->ruangan->nama_ruangan ?? '-',
                    'supplier' => '-',
                    'jumlah' => $item->jumlah
                ];
            });

        $mutasi = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => '🔄 Mutasi',
                    'barang' => $item->barang->nama_barang ?? '-',
                    'ruangan' => ($item->ruanganAsal->nama_ruangan ?? '-') . ' → ' . ($item->ruanganTujuan->nama_ruangan ?? '-'),
                    'supplier' => '-',
                    'jumlah' => $item->jumlah
                ];
            });

        // Gabungkan dan urutkan
        $transaksiTerbaru = collect()
            ->merge($barangMasuk)
            ->merge($barangKeluar)
            ->merge($mutasi)
            ->sortByDesc('tanggal')
            ->take(10);

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalRuangan',
            'totalStokMenipis',
            'stokMenipis',
            'stokPerKategori',
            'kondisiBaik',
            'kondisiRusak',
            'kondisiHilang',
            'transaksiTerbaru'
        ));
    }
}