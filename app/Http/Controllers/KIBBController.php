<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\InventarisRuangan;
use App\Exports\KIBbExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KIBBController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)
            ->with('inventarisRuangan.ruangan')
            ->get();
        return view('kib_b.index', compact('barangs'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        return view('kib_b.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'required|integer|min:0',
            'stok_hilang' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'merk' => 'nullable|string|max:50',
            'no_seri' => 'nullable|string|max:50',
        ]);

        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();

        if (!$kategori) {
            return redirect()->back()
                ->with('error', 'Kategori KIB B tidak ditemukan!')
                ->withInput();
        }

        try {
            $barang = Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'id_kategori' => $kategori->id_kategori,
                'stok_total' => $request->stok_baik + $request->stok_rusak + $request->stok_hilang,
                'min_stok' => 0,
                'harga' => $request->harga,
                'merk' => $request->merk,
                'no_seri' => $request->no_seri,
            ]);

            InventarisRuangan::create([
                'id_barang' => $barang->id_barang,
                'id_ruangan' => $request->id_ruangan,
                'stok_baik' => $request->stok_baik,
                'stok_rusak' => $request->stok_rusak,
                'stok_hilang' => $request->stok_hilang,
            ]);

            return redirect()->route('kib_b.index')
                ->with('success', 'Data peralatan berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'inventarisRuangan.ruangan'])->findOrFail($id);
        return view('kib_b.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::with('inventarisRuangan')->findOrFail($id);
        $ruangans = Ruangan::all();
        $inventaris = $barang->inventarisRuangan->first();
        return view('kib_b.edit', compact('barang', 'ruangans', 'inventaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id . ',id_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'required|integer|min:0',
            'stok_hilang' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'merk' => 'nullable|string|max:50',
            'no_seri' => 'nullable|string|max:50',
        ]);

        try {
            $barang = Barang::findOrFail($id);

            $barang->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'stok_total' => $request->stok_baik + $request->stok_rusak + $request->stok_hilang,
                'harga' => $request->harga,
                'merk' => $request->merk,
                'no_seri' => $request->no_seri,
            ]);

            $inventaris = InventarisRuangan::where('id_barang', $barang->id_barang)->first();
            if ($inventaris) {
                $inventaris->update([
                    'id_ruangan' => $request->id_ruangan,
                    'stok_baik' => $request->stok_baik,
                    'stok_rusak' => $request->stok_rusak,
                    'stok_hilang' => $request->stok_hilang,
                ]);
            } else {
                InventarisRuangan::create([
                    'id_barang' => $barang->id_barang,
                    'id_ruangan' => $request->id_ruangan,
                    'stok_baik' => $request->stok_baik,
                    'stok_rusak' => $request->stok_rusak,
                    'stok_hilang' => $request->stok_hilang,
                ]);
            }

            return redirect()->route('kib_b.index')
                ->with('success', 'Data peralatan berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        InventarisRuangan::where('id_barang', $barang->id_barang)->delete();
        $barang->delete();

        return redirect()->route('kib_b.index')
            ->with('success', 'Data peralatan berhasil dihapus!');
    }

    /**
     * Export Excel KIB B
     */
    public function exportExcel()
    {
        return Excel::download(new KIBbExport, 'laporan-kib-b-peralatan-' . date('Y-m-d') . '.xlsx');
    }
}