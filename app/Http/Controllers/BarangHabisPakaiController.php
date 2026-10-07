<?php

namespace App\Http\Controllers;

use App\Models\BarangHabisPakai;
use Illuminate\Http\Request;

class BarangHabisPakaiController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $tahun = request('tahun', date('Y'));
        $barangs = BarangHabisPakai::where('tahun', $tahun)->get();
        $tahunList = BarangHabisPakai::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        return view('barang_habis_pakai.index', compact('barangs', 'tahun', 'tahunList'));
    }

    // Form tambah
    public function create()
    {
        return view('barang_habis_pakai.create');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'sisa_awal' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['tahun'] = date('Y');

        // Inisialisasi semua bulan (M, K, JML, SISA)
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        foreach ($months as $month) {
            $data[$month . '_m'] = 0;
            $data[$month . '_k'] = 0;
            $data[$month . '_jml'] = 0;
            $data[$month . '_sisa'] = 0;
        }

        BarangHabisPakai::create($data);

        return redirect()->route('barang-habis-pakai.index')
            ->with('success', 'Data barang berhasil ditambahkan!');
    }

    // Detail
    public function show($id)
    {
        $barang = BarangHabisPakai::findOrFail($id);
        return view('barang_habis_pakai.show', compact('barang'));
    }

    // Form edit
    public function edit($id)
    {
        $barang = BarangHabisPakai::findOrFail($id);
        return view('barang_habis_pakai.edit', compact('barang'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $barang = BarangHabisPakai::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'sisa_awal' => 'required|integer|min:0',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang-habis-pakai.index')
            ->with('success', 'Data barang berhasil diupdate!');
    }

    // Update data per bulan (AJAX nanti, sekarang pake form biasa)
    public function updateBulan(Request $request, $id)
    {
        $barang = BarangHabisPakai::findOrFail($id);
        $bulan = $request->bulan;
        $m = $request->m ?? 0;
        $k = $request->k ?? 0;

        // Ambil sisa bulan lalu
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $index = array_search($bulan, $months);
        $sisaLalu = $index == 0 ? $barang->sisa_awal : $barang->{$months[$index - 1] . '_sisa'};

        $jml = $sisaLalu + $m - $k;
        $sisa = $jml;

        // Update field bulan ini
        $barang->{$bulan . '_m'} = $m;
        $barang->{$bulan . '_k'} = $k;
        $barang->{$bulan . '_jml'} = $jml;
        $barang->{$bulan . '_sisa'} = $sisa;
        $barang->save();

        return redirect()->route('barang-habis-pakai.show', $id)
            ->with('success', 'Data bulan ' . strtoupper($bulan) . ' berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $barang = BarangHabisPakai::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang-habis-pakai.index')
            ->with('success', 'Data barang berhasil dihapus!');
    }
}