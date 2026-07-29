<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangKeluars = BarangKeluar::with(['barang', 'ruangan'])->orderBy('tanggal', 'desc')->get();
        return view('barang_keluar.index', compact('barangKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('barang_keluar.create', compact('barangs', 'ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Cek stok di ruangan
        $stokTersedia = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'kondisi' => 'BAIK'
        ])->sum('stok');

        if ($stokTersedia < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $stokTersedia)
                ->withInput();
        }

        // Simpan transaksi barang keluar
        $barangKeluar = BarangKeluar::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'jumlah' => $request->jumlah
        ]);

        // Update stok di inventaris ruangan (kurangi)
        $this->updateInventarisRuangan($request->id_barang, $request->id_ruangan, $request->jumlah, 'keluar');

        // Update stok_total di tabel barang
        $this->updateStokTotal($request->id_barang);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'ruangan'])->findOrFail($id);
        return view('barang_keluar.show', compact('barangKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('barang_keluar.edit', compact('barangKeluar', 'barangs', 'ruangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);
        
        // Simpan data lama untuk rollback
        $oldBarangId = $barangKeluar->id_barang;
        $oldRuanganId = $barangKeluar->id_ruangan;
        $oldJumlah = $barangKeluar->jumlah;

        // Cek stok untuk update (jika berbeda)
        if ($oldBarangId != $request->id_barang || $oldRuanganId != $request->id_ruangan || $oldJumlah != $request->jumlah) {
            // Rollback stok lama (tambah kembali)
            $this->updateInventarisRuangan($oldBarangId, $oldRuanganId, $oldJumlah, 'masuk');

            // Cek stok baru
            $stokTersedia = InventarisRuangan::where([
                'id_barang' => $request->id_barang,
                'id_ruangan' => $request->id_ruangan,
                'kondisi' => 'BAIK'
            ])->sum('stok');

            if ($stokTersedia < $request->jumlah) {
                // Rollback lagi
                $this->updateInventarisRuangan($oldBarangId, $oldRuanganId, $oldJumlah, 'keluar');
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $stokTersedia)
                    ->withInput();
            }

            // Update data
            $barangKeluar->update([
                'tanggal' => $request->tanggal,
                'id_barang' => $request->id_barang,
                'id_ruangan' => $request->id_ruangan,
                'jumlah' => $request->jumlah
            ]);

            // Kurangi stok baru
            $this->updateInventarisRuangan($request->id_barang, $request->id_ruangan, $request->jumlah, 'keluar');

            // Update stok_total kedua barang
            $this->updateStokTotal($oldBarangId);
            if ($oldBarangId != $request->id_barang) {
                $this->updateStokTotal($request->id_barang);
            }
        } else {
            // Update tanpa perubahan stok (hanya tanggal)
            $barangKeluar->update([
                'tanggal' => $request->tanggal
            ]);
        }

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        
        // Rollback stok (tambah kembali)
        $this->updateInventarisRuangan(
            $barangKeluar->id_barang,
            $barangKeluar->id_ruangan,
            $barangKeluar->jumlah,
            'masuk'
        );

        // Hapus transaksi
        $barangKeluar->delete();

        // Update stok_total
        $this->updateStokTotal($barangKeluar->id_barang);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus!');
    }

    /**
     * Update inventaris ruangan (tambah atau kurangi stok)
     */
    private function updateInventarisRuangan($barangId, $ruanganId, $jumlah, $jenis)
    {
        // Cari data inventaris BAIK yang sesuai
        $inventaris = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $ruanganId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($jenis == 'masuk') {
            // Tambah stok (rollback)
            if ($inventaris) {
                $inventaris->stok += $jumlah;
                $inventaris->save();
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