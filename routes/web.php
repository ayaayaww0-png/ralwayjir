<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\InventarisRuanganController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\MutasiBarangController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::resource('kategori', KategoriController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('ruangan', RuanganController::class);
Route::resource('barang', BarangController::class);
Route::resource('inventaris', InventarisRuanganController::class);
Route::resource('barang-masuk', BarangMasukController::class);
Route::resource('barang-keluar', BarangKeluarController::class);
Route::resource('mutasi-barang', MutasiBarangController::class);

// ========== LAPORAN ROUTES ==========
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/stok-barang', [LaporanController::class, 'stokBarang'])->name('laporan.stok-barang');
Route::get('/laporan/inventaris-ruangan', [LaporanController::class, 'inventarisRuangan'])->name('laporan.inventaris-ruangan');
Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
Route::get('/laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');
Route::get('/laporan/mutasi-barang', [LaporanController::class, 'mutasiBarang'])->name('laporan.mutasi-barang');

// Route untuk cek stok (AJAX)
Route::get('/get-stok-ruangan', function (Request $request) {
    $barangId = $request->barang;
    $ruanganId = $request->ruangan;
    
    $stok = \App\Models\InventarisRuangan::where([
        'id_barang' => $barangId,
        'id_ruangan' => $ruanganId,
        'kondisi' => 'BAIK'
    ])->sum('stok');
    
    return response()->json(['stok' => $stok]);
})->name('get-stok-ruangan');