<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MutasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasiBarangs = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('mutasi_barang.index', compact('mutasiBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('mutasi_barang.create', compact('barangs', 'ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan_asal' => 'required|exists:ruangans,id_ruangan|different:id_ruangan_tujuan',
            'id_ruangan_tujuan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Cek stok di ruangan asal
        $stokTersedia = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan_asal,
            'kondisi' => 'BAIK'
        ])->sum('stok');

        if ($stokTersedia < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia di ruangan asal: ' . $stokTersedia)
                ->withInput();
        }

        // Simpan transaksi mutasi
        $mutasiBarang = MutasiBarang::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan_asal' => $request->id_ruangan_asal,
            'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
            'jumlah' => $request->jumlah
        ]);

        // Update stok di inventaris ruangan (asal dikurangi, tujuan ditambah)
        $this->mutasiStok(
            $request->id_barang,
            $request->id_ruangan_asal,
            $request->id_ruangan_tujuan,
            $request->jumlah
        );

        // Update stok_total di tabel barang
        $this->updateStokTotal($request->id_barang);

        return redirect()->route('mutasi-barang.index')
            ->with('success', 'Mutasi barang berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mutasiBarang = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])->findOrFail($id);
        return view('mutasi_barang.show', compact('mutasiBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mutasiBarang = MutasiBarang::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('mutasi_barang.edit', compact('mutasiBarang', 'barangs', 'ruangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan_asal' => 'required|exists:ruangans,id_ruangan|different:id_ruangan_tujuan',
            'id_ruangan_tujuan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1'
        ]);

        $mutasiBarang = MutasiBarang::findOrFail($id);
        
        // Simpan data lama untuk rollback
        $oldBarangId = $mutasiBarang->id_barang;
        $oldAsalId = $mutasiBarang->id_ruangan_asal;
        $oldTujuanId = $mutasiBarang->id_ruangan_tujuan;
        $oldJumlah = $mutasiBarang->jumlah;

        // Rollback mutasi lama
        $this->rollbackMutasi($oldBarangId, $oldAsalId, $oldTujuanId, $oldJumlah);

        // Cek stok baru di ruangan asal
        $stokTersedia = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan_asal,
            'kondisi' => 'BAIK'
        ])->sum('stok');

        if ($stokTersedia < $request->jumlah) {
            // Rollback lagi (kembalikan ke kondisi semula)
            $this->mutasiStok($oldBarangId, $oldAsalId, $oldTujuanId, $oldJumlah);
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia di ruangan asal: ' . $stokTersedia)
                ->withInput();
        }

        // Update data
        $mutasiBarang->update([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan_asal' => $request->id_ruangan_asal,
            'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
            'jumlah' => $request->jumlah
        ]);

        // Proses mutasi baru
        $this->mutasiStok(
            $request->id_barang,
            $request->id_ruangan_asal,
            $request->id_ruangan_tujuan,
            $request->jumlah
        );

        // Update stok_total kedua barang (lama dan baru)
        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('mutasi-barang.index')
            ->with('success', 'Mutasi barang berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mutasiBarang = MutasiBarang::findOrFail($id);
        
        // Rollback mutasi
        $this->rollbackMutasi(
            $mutasiBarang->id_barang,
            $mutasiBarang->id_ruangan_asal,
            $mutasiBarang->id_ruangan_tujuan,
            $mutasiBarang->jumlah
        );

        // Hapus transaksi
        $mutasiBarang->delete();

        // Update stok_total
        $this->updateStokTotal($mutasiBarang->id_barang);

        return redirect()->route('mutasi-barang.index')
            ->with('success', 'Mutasi barang berhasil dihapus!');
    }

    /**
     * Proses mutasi stok (asal dikurangi, tujuan ditambah)
     */
    private function mutasiStok($barangId, $asalId, $tujuanId, $jumlah)
    {
        // Kurangi stok di ruangan asal
        $inventarisAsal = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $asalId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($inventarisAsal) {
            $inventarisAsal->stok -= $jumlah;
            if ($inventarisAsal->stok < 0) {
                $inventarisAsal->stok = 0;
            }
            $inventarisAsal->save();
        }

        // Tambah stok di ruangan tujuan
        $inventarisTujuan = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $tujuanId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($inventarisTujuan) {
            $inventarisTujuan->stok += $jumlah;
            $inventarisTujuan->save();
        } else {
            // Buat baru jika belum ada di ruangan tujuan
            // Cari supplier dari ruangan asal
            $supplierAsal = InventarisRuangan::where([
                'id_barang' => $barangId,
                'id_ruangan' => $asalId,
                'kondisi' => 'BAIK'
            ])->value('id_supplier');

            if ($supplierAsal) {
                InventarisRuangan::create([
                    'id_barang' => $barangId,
                    'id_ruangan' => $tujuanId,
                    'id_supplier' => $supplierAsal,
                    'stok' => $jumlah,
                    'kondisi' => 'BAIK'
                ]);
            }
        }
    }

    /**
     * Rollback mutasi (kebalikan dari mutasiStok)
     */
    private function rollbackMutasi($barangId, $asalId, $tujuanId, $jumlah)
    {
        // Tambah kembali stok di ruangan asal
        $inventarisAsal = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $asalId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($inventarisAsal) {
            $inventarisAsal->stok += $jumlah;
            $inventarisAsal->save();
        }

        // Kurangi stok di ruangan tujuan
        $inventarisTujuan = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $tujuanId,
            'kondisi' => 'BAIK'
        ])->first();

        if ($inventarisTujuan) {
            $inventarisTujuan->stok -= $jumlah;
            if ($inventarisTujuan->stok < 0) {
                $inventarisTujuan->stok = 0;
            }
            $inventarisTujuan->save();
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