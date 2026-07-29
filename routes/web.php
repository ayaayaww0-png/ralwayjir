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