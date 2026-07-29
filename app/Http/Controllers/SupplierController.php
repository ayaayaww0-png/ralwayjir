<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:50|unique:suppliers,nama_supplier'
        ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:50|unique:suppliers,nama_supplier,' . $id . ',id_supplier'
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'nama_supplier' => $request->nama_supplier
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        // Cek apakah supplier masih digunakan di tabel inventaris_ruangan atau barang_masuk
        if ($supplier->inventarisRuangan()->count() > 0 || $supplier->barangMasuk()->count() > 0) {
            return redirect()->route('supplier.index')
                ->with('error', 'Supplier tidak bisa dihapus karena masih digunakan di transaksi!');
        }

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus!');
    }
}