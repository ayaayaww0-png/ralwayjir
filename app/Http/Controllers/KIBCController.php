<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\KIBCGedung;
use App\Exports\KIBcExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KIBCController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('nama_kategori', 'KIB C (Gedung & Bangunan)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)
            ->with('kibCGedung')
            ->get();
        return view('kib_c.index', compact('barangs'));
    }

    public function create()
    {
        return view('kib_c.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'register' => 'nullable|string|max:50',
            'kondisi_bangunan' => 'nullable|in:B,KB,RB',
            'bertingkat' => 'nullable|in:Ya,Tidak',
            'beton' => 'nullable|in:Ya,Tidak',
            'luas_lantai' => 'nullable|numeric|min:0',
            'tahun_pembangunan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'lokasi_alamat' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'nomor_dokumen' => 'nullable|string|max:50',
            'luas_tanah' => 'nullable|numeric|min:0',
            'status_tanah' => 'nullable|string|max:50',
            'kode_tanah' => 'nullable|string|max:50',
            'asal_usul' => 'nullable|string|max:50',
            'harga' => 'required|numeric|min:0',
        ]);

        $kategori = Kategori::where('nama_kategori', 'KIB C (Gedung & Bangunan)')->first();

        if (!$kategori) {
            return redirect()->back()
                ->with('error', 'Kategori KIB C (Gedung & Bangunan) tidak ditemukan!')
                ->withInput();
        }

        try {
            $barang = Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'id_kategori' => $kategori->id_kategori,
                'stok_total' => 1,
                'min_stok' => 0,
                'harga' => $request->harga,
                'register' => $request->register,
                'lokasi' => $request->lokasi_alamat,
                'status_tanah' => $request->status_tanah,
                'kode_tanah' => $request->kode_tanah,
                'asal_usul' => $request->asal_usul,
            ]);

            KIBCGedung::create([
                'id_barang' => $barang->id_barang,
                'register' => $request->register,
                'kondisi_bangunan' => $request->kondisi_bangunan,
                'bertingkat' => $request->bertingkat,
                'beton' => $request->beton,
                'luas_lantai' => $request->luas_lantai,
                'tahun_pembangunan' => $request->tahun_pembangunan,
                'lokasi_alamat' => $request->lokasi_alamat,
                'tanggal_dokumen' => $request->tanggal_dokumen,
                'nomor_dokumen' => $request->nomor_dokumen,
                'luas_tanah' => $request->luas_tanah,
                'status_tanah' => $request->status_tanah,
                'kode_tanah' => $request->kode_tanah,
                'asal_usul' => $request->asal_usul,
            ]);

            return redirect()->route('kib_c.index')
                ->with('success', 'Data gedung berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'kibCGedung'])->findOrFail($id);
        return view('kib_c.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::with('kibCGedung')->findOrFail($id);
        return view('kib_c.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id . ',id_barang|max:50',
            'nama_barang' => 'required|string|max:100',
            'register' => 'nullable|string|max:50',
            'kondisi_bangunan' => 'nullable|in:B,KB,RB',
            'bertingkat' => 'nullable|in:Ya,Tidak',
            'beton' => 'nullable|in:Ya,Tidak',
            'luas_lantai' => 'nullable|numeric|min:0',
            'tahun_pembangunan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'lokasi_alamat' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'nomor_dokumen' => 'nullable|string|max:50',
            'luas_tanah' => 'nullable|numeric|min:0',
            'status_tanah' => 'nullable|string|max:50',
            'kode_tanah' => 'nullable|string|max:50',
            'asal_usul' => 'nullable|string|max:50',
            'harga' => 'required|numeric|min:0',
        ]);

        $barang = Barang::findOrFail($id);

        try {
            $barang->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'register' => $request->register,
                'lokasi' => $request->lokasi_alamat,
                'status_tanah' => $request->status_tanah,
                'kode_tanah' => $request->kode_tanah,
                'asal_usul' => $request->asal_usul,
            ]);

            $gedung = KIBCGedung::where('id_barang', $barang->id_barang)->first();
            if ($gedung) {
                $gedung->update([
                    'register' => $request->register,
                    'kondisi_bangunan' => $request->kondisi_bangunan,
                    'bertingkat' => $request->bertingkat,
                    'beton' => $request->beton,
                    'luas_lantai' => $request->luas_lantai,
                    'tahun_pembangunan' => $request->tahun_pembangunan,
                    'lokasi_alamat' => $request->lokasi_alamat,
                    'tanggal_dokumen' => $request->tanggal_dokumen,
                    'nomor_dokumen' => $request->nomor_dokumen,
                    'luas_tanah' => $request->luas_tanah,
                    'status_tanah' => $request->status_tanah,
                    'kode_tanah' => $request->kode_tanah,
                    'asal_usul' => $request->asal_usul,
                ]);
            }

            return redirect()->route('kib_c.index')
                ->with('success', 'Data gedung berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        KIBCGedung::where('id_barang', $barang->id_barang)->delete();
        $barang->delete();

        return redirect()->route('kib_c.index')
            ->with('success', 'Data gedung berhasil dihapus!');
    }

    /**
     * Export Excel KIB C
     */
    public function exportExcel()
    {
        return Excel::download(new KIBcExport, 'laporan-kib-c-gedung-' . date('Y-m-d') . '.xlsx');
    }
}