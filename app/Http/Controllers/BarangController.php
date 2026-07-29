<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:15|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'min_stok' => 'required|integer|min:0'
        ]);

        // 🔥 HAPUS stok_total dari sini, default 0
        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'stok_total' => 0, // DEFAULT 0
            'min_stok' => $request->min_stok
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan! Stok awal 0, silakan input barang masuk.');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'inventarisRuangan.ruangan', 'barangMasuk', 'barangKeluar', 'mutasiBarang'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'kode_barang' => 'required|string|max:15|unique:barangs,kode_barang,' . $id . ',id_barang',
        'nama_barang' => 'required|string|max:50',
        'id_kategori' => 'required|exists:kategoris,id_kategori',
        'min_stok' => 'required|integer|min:0'
    ]);

    $barang = Barang::findOrFail($id);
    
    // 🔥 UPDATE TANPA STOK_TOTAL
    $barang->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'id_kategori' => $request->id_kategori,
        'min_stok' => $request->min_stok
        // stok_total TIDAK DIUPDATE
    ]);

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil diupdate!');
}

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Hapus inventaris terkait
        \App\Models\InventarisRuangan::where('id_barang', $barang->id_barang)->delete();

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}