<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangMasuks = BarangMasuk::with(['barang', 'supplier', 'ruangan'])->orderBy('tanggal', 'desc')->get();
        return view('barang_masuk.index', compact('barangMasuks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $ruangans = Ruangan::all();
        return view('barang_masuk.create', compact('barangs', 'suppliers', 'ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Simpan transaksi barang masuk
        $barangMasuk = BarangMasuk::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'id_ruangan' => $request->id_ruangan,
            'jumlah' => $request->jumlah
        ]);

        // Update stok di inventaris ruangan
        $this->updateInventarisRuangan($request->id_barang, $request->id_ruangan, $request->id_supplier, $request->jumlah, 'masuk');

        // Update stok_total di tabel barang
        $this->updateStokTotal($request->id_barang);

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier', 'ruangan'])->findOrFail($id);
        return view('barang_masuk.show', compact('barangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $ruangans = Ruangan::all();
        return view('barang_masuk.edit', compact('barangMasuk', 'barangs', 'suppliers', 'ruangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        
        // Simpan data lama untuk rollback
        $oldBarangId = $barangMasuk->id_barang;
        $oldRuanganId = $barangMasuk->id_ruangan;
        $oldSupplierId = $barangMasuk->id_supplier;
        $oldJumlah = $barangMasuk->jumlah;

        // Rollback stok lama (kurangi)
        $this->updateInventarisRuangan($oldBarangId, $oldRuanganId, $oldSupplierId, $oldJumlah, 'keluar');

        // Update data
        $barangMasuk->update([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'id_ruangan' => $request->id_ruangan,
            'jumlah' => $request->jumlah
        ]);

        // Tambah stok baru
        $this->updateInventarisRuangan($request->id_barang, $request->id_ruangan, $request->id_supplier, $request->jumlah, 'masuk');

        // Update stok_total kedua barang (lama dan baru)
        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        
        // Rollback stok (kurangi)
        $this->updateInventarisRuangan(
            $barangMasuk->id_barang,
            $barangMasuk->id_ruangan,
            $barangMasuk->id_supplier,
            $barangMasuk->jumlah,
            'keluar'
        );

        // Hapus transaksi
        $barangMasuk->delete();

        // Update stok_total
        $this->updateStokTotal($barangMasuk->id_barang);

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus!');
    }

    /**
     * Update inventaris ruangan (tambah atau kurangi stok)
     */
    private function updateInventarisRuangan($barangId, $ruanganId, $supplierId, $jumlah, $jenis)
    {
        // Cari data inventaris yang sesuai
        $inventaris = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $ruanganId,
            'id_supplier' => $supplierId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($jenis == 'masuk') {
            // Tambah stok
            if ($inventaris) {
                $inventaris->stok += $jumlah;
                $inventaris->save();
            } else {
                // Buat baru jika belum ada
                InventarisRuangan::create([
                    'id_barang' => $barangId,
                    'id_ruangan' => $ruanganId,
                    'id_supplier' => $supplierId,
                    'stok' => $jumlah,
                    'kondisi' => 'BAIK'
                ]);
            }
        } else {
            // Kurangi stok (keluar)
            if ($inventaris) {
                $inventaris->stok -= $jumlah;
                if ($inventaris->stok < 0) {
                    $inventaris->stok = 0;
                }
                $inventaris->save();
            }
        }
    }

    /**
     * Update stok_total di tabel barang
     */
    private function updateStokTotal($barangId)
    {
        $totalStok = InventarisRuangan::where('id_barang', $barangId)->sum('stok');
        Barang::where('id_barang', $barangId)->update(['stok_total' => $totalStok]);
    }
}