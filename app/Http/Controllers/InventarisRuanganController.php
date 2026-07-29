<?php

namespace App\Http\Controllers;

use App\Models\InventarisRuangan;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventarisRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventaris = InventarisRuangan::with(['barang', 'ruangan', 'supplier'])->get();
        return view('inventaris.index', compact('inventaris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        $suppliers = Supplier::all();
        return view('inventaris.create', compact('barangs', 'ruangans', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:BAIK,RUSAK,HILANG'
        ]);

        // Cek apakah sudah ada data dengan kombinasi barang + ruangan + supplier + kondisi yang sama
        $existing = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'id_supplier' => $request->id_supplier,
            'kondisi' => $request->kondisi
        ])->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Data inventaris sudah ada! Silakan edit atau tambah dengan kondisi berbeda.')
                ->withInput();
        }

        InventarisRuangan::create($request->all());

        // Update stok_total di tabel barang
        $this->updateStokTotal($request->id_barang);

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventaris = InventarisRuangan::with(['barang', 'ruangan', 'supplier'])->findOrFail($id);
        return view('inventaris.show', compact('inventaris'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventaris = InventarisRuangan::findOrFail($id);
        $barangs = Barang::all();
        $ruangans = Ruangan::all();
        $suppliers = Supplier::all();
        return view('inventaris.edit', compact('inventaris', 'barangs', 'ruangans', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:BAIK,RUSAK,HILANG'
        ]);

        $inventaris = InventarisRuangan::findOrFail($id);
        
        // Cek apakah ada duplikat (kecuali data sendiri)
        $existing = InventarisRuangan::where([
            'id_barang' => $request->id_barang,
            'id_ruangan' => $request->id_ruangan,
            'id_supplier' => $request->id_supplier,
            'kondisi' => $request->kondisi
        ])->where('id_inventaris', '!=', $id)->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Data inventaris sudah ada! Silakan pilih kombinasi yang berbeda.')
                ->withInput();
        }

        $oldBarangId = $inventaris->id_barang;
        $inventaris->update($request->all());

        // Update stok_total di tabel barang (lama dan baru)
        $this->updateStokTotal($oldBarangId);
        if ($oldBarangId != $request->id_barang) {
            $this->updateStokTotal($request->id_barang);
        }

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventaris = InventarisRuangan::findOrFail($id);
        $barangId = $inventaris->id_barang;
        
        $inventaris->delete();

        // Update stok_total di tabel barang
        $this->updateStokTotal($barangId);

        return redirect()->route('inventaris.index')
            ->with('success', 'Inventaris ruangan berhasil dihapus!');
    }

    /**
     * Update stok_total di tabel barang berdasarkan total stok di inventaris_ruangan
     */
    private function updateStokTotal($barangId)
    {
        $totalStok = InventarisRuangan::where('id_barang', $barangId)->sum('stok');
        \App\Models\Barang::where('id_barang', $barangId)->update(['stok_total' => $totalStok]);
    }
}