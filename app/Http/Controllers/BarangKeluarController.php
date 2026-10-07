<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluars = BarangKeluar::with(['barang', 'ruangan'])->orderBy('tanggal', 'desc')->get();
        return view('barang_keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        // Ambil hanya barang dari KIB B
        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)->get();
        $ruangans = Ruangan::all();
        return view('barang_keluar.create', compact('barangs', 'ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1',
            'jenis_keluar' => 'required|in:rusak,hilang',
        ]);

        // Cek stok BAIK di ruangan
        $inventaris = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
        ])->first();

        if (!$inventaris || $inventaris->stok_baik < $request->jumlah) {
            $stokTersedia = $inventaris->stok_baik ?? 0;
            return redirect()->back()
                ->with('error', "Stok BAIK tidak mencukupi! Stok tersedia: {$stokTersedia}")
                ->withInput();
        }

        // Simpan transaksi barang keluar
        $barangKeluar = BarangKeluar::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'jumlah' => $request->jumlah,
            'jenis_keluar' => $request->jenis_keluar,
        ]);

        // Update stok inventaris
        if ($request->jenis_keluar == 'rusak') {
            $inventaris->stok_baik -= $request->jumlah;
            $inventaris->stok_rusak += $request->jumlah;
        } else { // hilang
            $inventaris->stok_baik -= $request->jumlah;
            $inventaris->stok_hilang += $request->jumlah;
        }

        if ($inventaris->stok_baik < 0) $inventaris->stok_baik = 0;
        $inventaris->save();

        // Update stok_total barang
        $this->updateStokTotal($request->id_barang);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dicatat!');
    }

    public function show($id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'ruangan'])->findOrFail($id);
        return view('barang_keluar.show', compact('barangKeluar'));
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('barang_keluar.edit', compact('barangKeluar', 'barangs', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1',
            'jenis_keluar' => 'required|in:rusak,hilang',
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);

        $oldBarangId = $barangKeluar->id_barang;
        $oldRuanganId = $barangKeluar->id_ruangan;
        $oldJumlah = $barangKeluar->jumlah;
        $oldJenis = $barangKeluar->jenis_keluar;

        // Rollback stok lama
        $inventarisLama = InventarisRuangan::where([
            'id_barang' => $oldBarangId,
            'id_ruangan' => $oldRuanganId,
        ])->first();

        if ($inventarisLama) {
            if ($oldJenis == 'rusak') {
                $inventarisLama->stok_baik += $oldJumlah;
                $inventarisLama->stok_rusak -= $oldJumlah;
                if ($inventarisLama->stok_rusak < 0) $inventarisLama->stok_rusak = 0;
            } else {
                $inventarisLama->stok_baik += $oldJumlah;
                $inventarisLama->stok_hilang -= $oldJumlah;
                if ($inventarisLama->stok_hilang < 0) $inventarisLama->stok_hilang = 0;
            }
            $inventarisLama->save();
        }

        // Cek stok baru
        $inventarisBaru = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
        ])->first();

        if (!$inventarisBaru || $inventarisBaru->stok_baik < $request->jumlah) {
            // Rollback lagi
            $this->rollbackStok($oldBarangId, $oldRuanganId, $oldJumlah, $oldJenis);
            $stokTersedia = $inventarisBaru->stok_baik ?? 0;
            return redirect()->back()
                ->with('error', "Stok BAIK tidak mencukupi! Stok tersedia: {$stokTersedia}")
                ->withInput();
        }

        // Update data
        $barangKeluar->update([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'jumlah' => $request->jumlah,
            'jenis_keluar' => $request->jenis_keluar,
        ]);

        // Update stok baru
        if ($request->jenis_keluar == 'rusak') {
            $inventarisBaru->stok_baik -= $request->jumlah;
            $inventarisBaru->stok_rusak += $request->jumlah;
        } else {
            $inventarisBaru->stok_baik -= $request->jumlah;
            $inventarisBaru->stok_hilang += $request->jumlah;
        }

        if ($inventarisBaru->stok_baik < 0) $inventarisBaru->stok_baik = 0;
        $inventarisBaru->save();

        // Update stok_total
        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $inventaris = InventarisRuangan::where([
            'id_barang' => $barangKeluar->id_barang,
            'id_ruangan' => $barangKeluar->id_ruangan,
        ])->first();

        if ($inventaris) {
            if ($barangKeluar->jenis_keluar == 'rusak') {
                $inventaris->stok_baik += $barangKeluar->jumlah;
                $inventaris->stok_rusak -= $barangKeluar->jumlah;
                if ($inventaris->stok_rusak < 0) $inventaris->stok_rusak = 0;
            } else {
                $inventaris->stok_baik += $barangKeluar->jumlah;
                $inventaris->stok_hilang -= $barangKeluar->jumlah;
                if ($inventaris->stok_hilang < 0) $inventaris->stok_hilang = 0;
            }
            $inventaris->save();
        }

        $barangId = $barangKeluar->id_barang;
        $barangKeluar->delete();

        $this->updateStokTotal($barangId);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus!');
    }

    private function rollbackStok($barangId, $ruanganId, $jumlah, $jenis)
    {
        $inventaris = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $ruanganId,
        ])->first();

        if ($inventaris) {
            if ($jenis == 'rusak') {
                $inventaris->stok_baik += $jumlah;
                $inventaris->stok_rusak -= $jumlah;
                if ($inventaris->stok_rusak < 0) $inventaris->stok_rusak = 0;
            } else {
                $inventaris->stok_baik += $jumlah;
                $inventaris->stok_hilang -= $jumlah;
                if ($inventaris->stok_hilang < 0) $inventaris->stok_hilang = 0;
            }
            $inventaris->save();
        }
    }

    private function updateStokTotal($barangId)
    {
        $totalStok = InventarisRuangan::where('id_barang', $barangId)
            ->selectRaw('SUM(stok_baik + stok_rusak + stok_hilang) as total')
            ->value('total') ?? 0;

        Barang::where('id_barang', $barangId)->update(['stok_total' => $totalStok]);
    }
}