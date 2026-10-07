<?php

namespace App\Http\Controllers;

use App\Models\InventarisRuangan;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class InventarisRuanganController extends Controller
{
    public function index()
    {
        $inventaris = InventarisRuangan::with(['barang', 'ruangan'])->get();
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        // Ambil hanya barang dari KIB B
        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)->get();
        $ruangans = Ruangan::all();
        return view('inventaris.create', compact('barangs', 'ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'required|integer|min:0',
            'stok_hilang' => 'required|integer|min:0',
        ]);

        // Cek apakah barang KIB B
        $barang = Barang::find($request->id_barang);
        $kategori = Kategori::find($barang->id_kategori);
        if (!str_contains($kategori->nama_kategori, 'KIB B')) {
            return redirect()->back()
                ->with('error', 'Hanya barang KIB B (Peralatan & Mesin) yang bisa ditambahkan ke inventaris ruangan!')
                ->withInput();
        }

        // Cek duplikat
        $existing = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
        ])->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Data inventaris sudah ada! Silakan edit.')
                ->withInput();
        }

        $inventaris = InventarisRuangan::create([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'stok_baik' => $request->stok_baik,
            'stok_rusak' => $request->stok_rusak,
            'stok_hilang' => $request->stok_hilang,
        ]);

        $this->updateStokTotal($request->id_barang);

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $inventaris = InventarisRuangan::with(['barang', 'ruangan'])->findOrFail($id);
        return view('inventaris.show', compact('inventaris'));
    }

    public function edit($id)
    {
        $inventaris = InventarisRuangan::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        return view('inventaris.edit', compact('inventaris', 'barangs', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'required|integer|min:0',
            'stok_hilang' => 'required|integer|min:0',
        ]);

        $inventaris = InventarisRuangan::findOrFail($id);
        $oldBarangId = $inventaris->id_barang;

        $inventaris->update([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'stok_baik' => $request->stok_baik,
            'stok_rusak' => $request->stok_rusak,
            'stok_hilang' => $request->stok_hilang,
        ]);

        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $inventaris = InventarisRuangan::findOrFail($id);
        $barangId = $inventaris->id_barang;
        $inventaris->delete();

        $this->updateStokTotal($barangId);

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil dihapus!');
    }

    private function updateStokTotal($barangId)
    {
        $totalStok = InventarisRuangan::where('id_barang', $barangId)
            ->selectRaw('SUM(stok_baik + stok_rusak + stok_hilang) as total')
            ->value('total') ?? 0;

        Barang::where('id_barang', $barangId)->update(['stok_total' => $totalStok]);
    }
}