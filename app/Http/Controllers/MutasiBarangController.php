<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MutasiBarangController extends Controller
{
    public function index()
    {
        $mutasiBarangs = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('mutasi_barang.index', compact('mutasiBarangs'));
    }

    public function create()
    {
        // Ambil hanya barang dari KIB B
        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)->get();
        $ruangans = Ruangan::all();
        return view('mutasi_barang.create', compact('barangs', 'ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan_asal' => 'required|exists:ruangans,id_ruangan|different:id_ruangan_tujuan',
            'id_ruangan_tujuan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek stok di ruangan asal
        $inventarisAsal = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan_asal,
        ])->first();

        if (!$inventarisAsal || $inventarisAsal->stok_baik < $request->jumlah) {
            $stokTersedia = $inventarisAsal->stok_baik ?? 0;
            return redirect()->back()
                ->with('error', "Stok BAIK di ruangan asal tidak mencukupi! Stok tersedia: {$stokTersedia}")
                ->withInput();
        }

        // Simpan transaksi mutasi
        $mutasiBarang = MutasiBarang::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan_asal' => $request->id_ruangan_asal,
            'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
            'jumlah' => $request->jumlah,
        ]);

        // Proses mutasi stok
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

    public function show($id)
    {
        $mutasiBarang = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])->findOrFail($id);
        return view('mutasi_barang.show', compact('mutasiBarang'));
    }

    public function edit($id)
    {
        $mutasiBarang = MutasiBarang::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('mutasi_barang.edit', compact('mutasiBarang', 'barangs', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan_asal' => 'required|exists:ruangans,id_ruangan|different:id_ruangan_tujuan',
            'id_ruangan_tujuan' => 'required|exists:ruangans,id_ruangan',
            'jumlah' => 'required|integer|min:1',
        ]);

        $mutasiBarang = MutasiBarang::findOrFail($id);

        $oldBarangId = $mutasiBarang->id_barang;
        $oldAsalId = $mutasiBarang->id_ruangan_asal;
        $oldTujuanId = $mutasiBarang->id_ruangan_tujuan;
        $oldJumlah = $mutasiBarang->jumlah;

        // Rollback mutasi lama
        $this->rollbackMutasi($oldBarangId, $oldAsalId, $oldTujuanId, $oldJumlah);

        // Cek stok baru di ruangan asal
        $inventarisBaru = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan_asal,
        ])->first();

        if (!$inventarisBaru || $inventarisBaru->stok_baik < $request->jumlah) {
            // Rollback lagi (kembalikan ke kondisi semula)
            $this->mutasiStok($oldBarangId, $oldAsalId, $oldTujuanId, $oldJumlah);
            $stokTersedia = $inventarisBaru->stok_baik ?? 0;
            return redirect()->back()
                ->with('error', "Stok BAIK di ruangan asal tidak mencukupi! Stok tersedia: {$stokTersedia}")
                ->withInput();
        }

        // Update data
        $mutasiBarang->update([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_ruangan_asal' => $request->id_ruangan_asal,
            'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
            'jumlah' => $request->jumlah,
        ]);

        // Proses mutasi baru
        $this->mutasiStok(
            $request->id_barang,
            $request->id_ruangan_asal,
            $request->id_ruangan_tujuan,
            $request->jumlah
        );

        // Update stok_total
        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('mutasi-barang.index')
            ->with('success', 'Mutasi barang berhasil diupdate!');
    }

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

        $barangId = $mutasiBarang->id_barang;
        $mutasiBarang->delete();

        // Update stok_total
        $this->updateStokTotal($barangId);

        return redirect()->route('mutasi-barang.index')
            ->with('success', 'Mutasi barang berhasil dihapus!');
    }

    private function mutasiStok($barangId, $asalId, $tujuanId, $jumlah)
    {
        // Kurangi stok di ruangan asal
        $inventarisAsal = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $asalId,
        ])->first();

        if ($inventarisAsal) {
            $inventarisAsal->stok_baik -= $jumlah;
            if ($inventarisAsal->stok_baik < 0) $inventarisAsal->stok_baik = 0;
            $inventarisAsal->save();
        }

        // Tambah stok di ruangan tujuan
        $inventarisTujuan = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $tujuanId,
        ])->first();

        if ($inventarisTujuan) {
            $inventarisTujuan->stok_baik += $jumlah;
            $inventarisTujuan->save();
        } else {
            // Buat baru jika belum ada di ruangan tujuan
            InventarisRuangan::create([
                'id_barang' => $barangId,
                'id_ruangan' => $tujuanId,
                'stok_baik' => $jumlah,
                'stok_rusak' => 0,
                'stok_hilang' => 0,
            ]);
        }
    }

    private function rollbackMutasi($barangId, $asalId, $tujuanId, $jumlah)
    {
        // Tambah kembali stok di ruangan asal
        $inventarisAsal = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $asalId,
        ])->first();

        if ($inventarisAsal) {
            $inventarisAsal->stok_baik += $jumlah;
            $inventarisAsal->save();
        }

        // Kurangi stok di ruangan tujuan
        $inventarisTujuan = InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $tujuanId,
        ])->first();

        if ($inventarisTujuan) {
            $inventarisTujuan->stok_baik -= $jumlah;
            if ($inventarisTujuan->stok_baik < 0) $inventarisTujuan->stok_baik = 0;
            $inventarisTujuan->save();
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