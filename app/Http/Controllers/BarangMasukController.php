<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with(['barang', 'supplier', 'ruangan'])->orderBy('tanggal', 'desc')->get();
        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $ruangans = Ruangan::all();
        $kategoris = Kategori::all();
        return view('barang_masuk.create', compact('barangs', 'suppliers', 'ruangans', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|integer|min:0',
        ]);

        // Cek kategori barang
        $barang = Barang::find($request->id_barang);
        $kategori = Kategori::find($barang->id_kategori);
        $isKIBB = str_contains($kategori->nama_kategori, 'KIB B');

        // Validasi ruangan khusus KIB B
        if ($isKIBB) {
            $request->validate([
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            ]);
        }

        // Simpan transaksi
        $data = [
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
        ];

        // KIB A & C: ruangan null
        if ($isKIBB) {
            $data['id_ruangan'] = $request->id_ruangan;
        } else {
            $data['id_ruangan'] = null;
            // KIB A & C: jumlah otomatis 1
            $data['jumlah'] = 1;
        }

        $barangMasuk = BarangMasuk::create($data);

        // Update stok untuk KIB B
        if ($isKIBB) {
            $inventaris = InventarisRuangan::where([
                'id_barang' => $request->id_barang,
                'id_ruangan' => $request->id_ruangan,
            ])->first();

            if ($inventaris) {
                $inventaris->stok_baik += $request->jumlah;
                $inventaris->save();
            } else {
                InventarisRuangan::create([
                    'id_barang' => $request->id_barang,
                    'id_ruangan' => $request->id_ruangan,
                    'stok_baik' => $request->jumlah,
                    'stok_rusak' => 0,
                    'stok_hilang' => 0,
                ]);
            }

            // Update stok_total
            $this->updateStokTotal($request->id_barang);
        }

        // Update harga barang (untuk semua KIB)
        if ($request->harga_beli > 0) {
            $barang->harga = $request->harga_beli;
            $barang->save();
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dicatat!');
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier', 'ruangan'])->findOrFail($id);
        return view('barang_masuk.show', compact('barangMasuk'));
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $ruangans = Ruangan::all();
        return view('barang_masuk.edit', compact('barangMasuk', 'barangs', 'suppliers', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|integer|min:0',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barang = Barang::find($request->id_barang);
        $kategori = Kategori::find($barang->id_kategori);
        $isKIBB = str_contains($kategori->nama_kategori, 'KIB B');

        if ($isKIBB) {
            $request->validate([
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            ]);
        }

        // Rollback stok lama (hanya KIB B)
        if ($barangMasuk->id_ruangan) {
            $inventarisLama = InventarisRuangan::where([
                'id_barang' => $barangMasuk->id_barang,
                'id_ruangan' => $barangMasuk->id_ruangan,
            ])->first();
            if ($inventarisLama) {
                $inventarisLama->stok_baik -= $barangMasuk->jumlah;
                if ($inventarisLama->stok_baik < 0) $inventarisLama->stok_baik = 0;
                $inventarisLama->save();
            }
        }

        // Update data
        $data = [
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
        ];

        if ($isKIBB) {
            $data['id_ruangan'] = $request->id_ruangan;
        } else {
            $data['id_ruangan'] = null;
            $data['jumlah'] = 1;
        }

        $barangMasuk->update($data);

        // Update stok baru (KIB B)
        if ($isKIBB) {
            $inventarisBaru = InventarisRuangan::where([
                'id_barang' => $request->id_barang,
                'id_ruangan' => $request->id_ruangan,
            ])->first();

            if ($inventarisBaru) {
                $inventarisBaru->stok_baik += $request->jumlah;
                $inventarisBaru->save();
            } else {
                InventarisRuangan::create([
                    'id_barang' => $request->id_barang,
                    'id_ruangan' => $request->id_ruangan,
                    'stok_baik' => $request->jumlah,
                    'stok_rusak' => 0,
                    'stok_hilang' => 0,
                ]);
            }

            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Rollback stok (KIB B)
        if ($barangMasuk->id_ruangan) {
            $inventaris = InventarisRuangan::where([
                'id_barang' => $barangMasuk->id_barang,
                'id_ruangan' => $barangMasuk->id_ruangan,
            ])->first();

            if ($inventaris) {
                $inventaris->stok_baik -= $barangMasuk->jumlah;
                if ($inventaris->stok_baik < 0) $inventaris->stok_baik = 0;
                $inventaris->save();
            }
        }

        $barangId = $barangMasuk->id_barang;
        $barangMasuk->delete();

        // Update stok_total
        $barang = Barang::find($barangId);
        $kategori = Kategori::find($barang->id_kategori);
        if (str_contains($kategori->nama_kategori, 'KIB B')) {
            $this->updateStokTotal($barangId);
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus!');
    }

    private function updateStokTotal($barangId)
    {
        $totalStok = InventarisRuangan::where('id_barang', $barangId)
            ->selectRaw('SUM(stok_baik + stok_rusak + stok_hilang) as total')
            ->value('total') ?? 0;

        Barang::where('id_barang', $barangId)->update(['stok_total' => $totalStok]);
    }
}