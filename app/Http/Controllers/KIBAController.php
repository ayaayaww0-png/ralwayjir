<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Exports\KIBaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KIBAController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('nama_kategori', 'KIB A (Tanah)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)->get();
        return view('kib_a.index', compact('barangs'));
    }

    public function create()
    {
        return view('kib_a.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'register' => 'nullable|string|max:50',
            'luas' => 'required|numeric|min:0',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'lokasi' => 'required|string|max:255',
            'status_tanah' => 'nullable|string|max:50',
            'kode_tanah' => 'nullable|string|max:50',
            'asal_usul' => 'nullable|string|max:50',
            'harga' => 'required|numeric|min:0',
        ]);

        $kategori = Kategori::where('nama_kategori', 'KIB A (Tanah)')->first();

        if (!$kategori) {
            return redirect()->back()
                ->with('error', 'Kategori KIB A (Tanah) tidak ditemukan!')
                ->withInput();
        }

        try {
            Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'id_kategori' => $kategori->id_kategori,
                'stok_total' => 1,
                'min_stok' => 0,
                'harga' => $request->harga,
                'register' => $request->register,
                'luas' => $request->luas,
                'tahun' => $request->tahun,
                'lokasi' => $request->lokasi,
                'status_tanah' => $request->status_tanah,
                'kode_tanah' => $request->kode_tanah,
                'asal_usul' => $request->asal_usul,
            ]);

            return redirect()->route('kib_a.index')
                ->with('success', 'Data tanah berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('kib_a.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('kib_a.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id . ',id_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'register' => 'nullable|string|max:50',
            'luas' => 'required|numeric|min:0',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'lokasi' => 'required|string|max:255',
            'status_tanah' => 'nullable|string|max:50',
            'kode_tanah' => 'nullable|string|max:50',
            'asal_usul' => 'nullable|string|max:50',
            'harga' => 'required|numeric|min:0',
        ]);

        try {
            $barang = Barang::findOrFail($id);

            $barang->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'register' => $request->register,
                'luas' => $request->luas,
                'tahun' => $request->tahun,
                'lokasi' => $request->lokasi,
                'status_tanah' => $request->status_tanah,
                'kode_tanah' => $request->kode_tanah,
                'asal_usul' => $request->asal_usul,
            ]);

            return redirect()->route('kib_a.index')
                ->with('success', 'Data tanah berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('kib_a.index')
            ->with('success', 'Data tanah berhasil dihapus!');
    }

    /**
     * Export Excel KIB A
     */
    public function exportExcel()
    {
        return Excel::download(new KIBaExport, 'laporan-kib-a-tanah-' . date('Y-m-d') . '.xlsx');
    }
}