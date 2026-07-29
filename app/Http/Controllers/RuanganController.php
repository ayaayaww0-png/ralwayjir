<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('ruangan.index', compact('ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50|unique:ruangans,nama_ruangan'
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return redirect()->route('ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.show', compact('ruangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50|unique:ruangans,nama_ruangan,' . $id . ',id_ruangan'
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return redirect()->route('ruangan.index')
            ->with('success', 'Ruangan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        // Cek apakah ruangan masih digunakan di tabel lain
        if ($ruangan->inventarisRuangan()->count() > 0 || 
            $ruangan->barangMasuk()->count() > 0 || 
            $ruangan->barangKeluar()->count() > 0 || 
            $ruangan->mutasiAsal()->count() > 0 || 
            $ruangan->mutasiTujuan()->count() > 0) {
            return redirect()->route('ruangan.index')
                ->with('error', 'Ruangan tidak bisa dihapus karena masih digunakan di transaksi atau inventaris!');
        }

        $ruangan->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}