<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Supplier;
use App\Models\InventarisRuangan;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan
     */
    public function index()
    {
        return view('laporan.index');
    }

    /**
     * LAPORAN 1: Stok Barang
     */
    public function stokBarang(Request $request)
    {
        $query = Barang::with('kategori');

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'habis') {
                $query->where('stok_total', 0);
            } elseif ($request->status == 'menipis') {
                $query->where('stok_total', '>', 0)->whereRaw('stok_total <= min_stok');
            } elseif ($request->status == 'aman') {
                $query->whereRaw('stok_total > min_stok');
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_barang', 'LIKE', "%$search%")
                  ->orWhere('nama_barang', 'LIKE', "%$search%");
            });
        }

        $barangs = $query->get();
        $kategoris = Kategori::all();

        // Jika request cetak PDF
        if ($request->has('cetak_pdf')) {
            $pdf = Pdf::loadView('laporan.cetak.stok_barang', compact('barangs', 'kategoris'));
            return $pdf->download('laporan-stok-barang.pdf');
        }

        return view('laporan.stok_barang', compact('barangs', 'kategoris'));
    }

    /**
     * LAPORAN 2: Inventaris per Ruangan
     */
    public function inventarisRuangan(Request $request)
    {
        $query = InventarisRuangan::with(['barang', 'ruangan', 'supplier']);

        // Filter by ruangan
        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        // Filter by kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $inventaris = $query->get();
        $ruangans = Ruangan::all();

        if ($request->has('cetak_pdf')) {
            $pdf = Pdf::loadView('laporan.cetak.inventaris_ruangan', compact('inventaris', 'ruangans'));
            return $pdf->download('laporan-inventaris-ruangan.pdf');
        }

        return view('laporan.inventaris_ruangan', compact('inventaris', 'ruangans'));
    }

    /**
     * LAPORAN 3: Barang Masuk
     */
    public function barangMasuk(Request $request)
    {
        $query = BarangMasuk::with(['barang', 'supplier', 'ruangan']);

        // Filter by tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter by supplier
        if ($request->filled('supplier')) {
            $query->where('id_supplier', $request->supplier);
        }

        // Filter by ruangan
        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        $barangMasuks = $query->orderBy('tanggal', 'desc')->get();
        $suppliers = Supplier::all();
        $ruangans = Ruangan::all();

        if ($request->has('cetak_pdf')) {
            $pdf = Pdf::loadView('laporan.cetak.barang_masuk', compact('barangMasuks', 'suppliers', 'ruangans'));
            return $pdf->download('laporan-barang-masuk.pdf');
        }

        return view('laporan.barang_masuk', compact('barangMasuks', 'suppliers', 'ruangans'));
    }

    /**
     * LAPORAN 4: Barang Keluar
     */
    public function barangKeluar(Request $request)
    {
        $query = BarangKeluar::with(['barang', 'ruangan']);

        // Filter by tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter by ruangan
        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        $barangKeluars = $query->orderBy('tanggal', 'desc')->get();
        $ruangans = Ruangan::all();

        if ($request->has('cetak_pdf')) {
            $pdf = Pdf::loadView('laporan.cetak.barang_keluar', compact('barangKeluars', 'ruangans'));
            return $pdf->download('laporan-barang-keluar.pdf');
        }

        return view('laporan.barang_keluar', compact('barangKeluars', 'ruangans'));
    }

    /**
     * LAPORAN 5: Mutasi Barang
     */
    public function mutasiBarang(Request $request)
    {
        $query = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan']);

        // Filter by tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter by ruangan asal
        if ($request->filled('ruangan_asal')) {
            $query->where('id_ruangan_asal', $request->ruangan_asal);
        }

        // Filter by ruangan tujuan
        if ($request->filled('ruangan_tujuan')) {
            $query->where('id_ruangan_tujuan', $request->ruangan_tujuan);
        }

        $mutasiBarangs = $query->orderBy('tanggal', 'desc')->get();
        $ruangans = Ruangan::all();

        if ($request->has('cetak_pdf')) {
            $pdf = Pdf::loadView('laporan.cetak.mutasi_barang', compact('mutasiBarangs', 'ruangans'));
            return $pdf->download('laporan-mutasi-barang.pdf');
        }

        return view('laporan.mutasi_barang', compact('mutasiBarangs', 'ruangans'));
    }
}