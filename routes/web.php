<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\InventarisRuanganController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\MutasiBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KIBAController;
use App\Http\Controllers\KIBBController;
use App\Http\Controllers\KIBCController;
use App\Http\Controllers\BarangHabisPakaiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ========== AUTH ROUTES ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== PROTECTED ROUTES (HARUS LOGIN) ==========
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // ========== KONTAK (SEMUA ROLE) ==========
    Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');

    // ========== ADMIN ONLY (CRUD - CREATE, EDIT, DELETE) ==========
    Route::middleware(['role:admin'])->group(function () {
        // Kategori
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Supplier
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        // Ruangan
        Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
        Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
        Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
        Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
        Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

        // Inventaris
        Route::get('/inventaris/create', [InventarisRuanganController::class, 'create'])->name('inventaris.create');
        Route::post('/inventaris', [InventarisRuanganController::class, 'store'])->name('inventaris.store');
        Route::get('/inventaris/{id}/edit', [InventarisRuanganController::class, 'edit'])->name('inventaris.edit');
        Route::put('/inventaris/{id}', [InventarisRuanganController::class, 'update'])->name('inventaris.update');
        Route::delete('/inventaris/{id}', [InventarisRuanganController::class, 'destroy'])->name('inventaris.destroy');

        // Barang Masuk
        Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
        Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
        Route::get('/barang-masuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
        Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
        Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');

        // Barang Keluar
        Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
        Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
        Route::get('/barang-keluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barang-keluar.edit');
        Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
        Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');

        // Mutasi Barang
        Route::get('/mutasi-barang/create', [MutasiBarangController::class, 'create'])->name('mutasi-barang.create');
        Route::post('/mutasi-barang', [MutasiBarangController::class, 'store'])->name('mutasi-barang.store');
        Route::get('/mutasi-barang/{id}/edit', [MutasiBarangController::class, 'edit'])->name('mutasi-barang.edit');
        Route::put('/mutasi-barang/{id}', [MutasiBarangController::class, 'update'])->name('mutasi-barang.update');
        Route::delete('/mutasi-barang/{id}', [MutasiBarangController::class, 'destroy'])->name('mutasi-barang.destroy');
    });

    // ========== ADMIN & KEPSEK (INDEX & SHOW - LIHAT DATA) ==========
    Route::middleware(['role:admin,kepsek'])->group(function () {
        // Index (Lihat semua data)
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
        Route::get('/inventaris', [InventarisRuanganController::class, 'index'])->name('inventaris.index');
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
        Route::get('/mutasi-barang', [MutasiBarangController::class, 'index'])->name('mutasi-barang.index');

        // Show (Detail)
        Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
        Route::get('/supplier/{id}', [SupplierController::class, 'show'])->name('supplier.show');
        Route::get('/ruangan/{id}', [RuanganController::class, 'show'])->name('ruangan.show');
        Route::get('/inventaris/{id}', [InventarisRuanganController::class, 'show'])->name('inventaris.show');
        Route::get('/barang-masuk/{id}', [BarangMasukController::class, 'show'])->name('barang-masuk.show');
        Route::get('/barang-keluar/{id}', [BarangKeluarController::class, 'show'])->name('barang-keluar.show');
        Route::get('/mutasi-barang/{id}', [MutasiBarangController::class, 'show'])->name('mutasi-barang.show');
    });

    // ========== LAPORAN (ADMIN & KEPSEK) ==========
    Route::middleware(['role:admin,kepsek'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/stok-barang', [LaporanController::class, 'stokBarang'])->name('laporan.stok-barang');
        Route::get('/laporan/inventaris-ruangan', [LaporanController::class, 'inventarisRuangan'])->name('laporan.inventaris-ruangan');
        Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
        Route::get('/laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');
        Route::get('/laporan/mutasi-barang', [LaporanController::class, 'mutasiBarang'])->name('laporan.mutasi-barang');
    });

    // ========== KIB ROUTES ==========
    // KIB A (Tanah) - Full CRUD untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kib_a/create', [KIBAController::class, 'create'])->name('kib_a.create');
        Route::post('/kib_a', [KIBAController::class, 'store'])->name('kib_a.store');
        Route::get('/kib_a/{id}/edit', [KIBAController::class, 'edit'])->name('kib_a.edit');
        Route::put('/kib_a/{id}', [KIBAController::class, 'update'])->name('kib_a.update');
        Route::delete('/kib_a/{id}', [KIBAController::class, 'destroy'])->name('kib_a.destroy');
    });

    // KIB A - Lihat (Admin & Kepsek) + Export Excel
    Route::middleware(['role:admin,kepsek'])->group(function () {
        Route::get('/kib_a', [KIBAController::class, 'index'])->name('kib_a.index');
        Route::get('/kib_a/{id}', [KIBAController::class, 'show'])->name('kib_a.show');
        // Export Excel KIB A
        Route::get('/export/kib-a', [KIBAController::class, 'exportExcel'])->name('export.kib-a');
    });

    // KIB B (Peralatan & Mesin) - Full CRUD untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kib_b/create', [KIBBController::class, 'create'])->name('kib_b.create');
        Route::post('/kib_b', [KIBBController::class, 'store'])->name('kib_b.store');
        Route::get('/kib_b/{id}/edit', [KIBBController::class, 'edit'])->name('kib_b.edit');
        Route::put('/kib_b/{id}', [KIBBController::class, 'update'])->name('kib_b.update');
        Route::delete('/kib_b/{id}', [KIBBController::class, 'destroy'])->name('kib_b.destroy');
    });

    // KIB B - Lihat (Admin & Kepsek) + Export Excel
    Route::middleware(['role:admin,kepsek'])->group(function () {
        Route::get('/kib_b', [KIBBController::class, 'index'])->name('kib_b.index');
        Route::get('/kib_b/{id}', [KIBBController::class, 'show'])->name('kib_b.show');
        // Export Excel KIB B
        Route::get('/export/kib-b', [KIBBController::class, 'exportExcel'])->name('export.kib-b');
    });

    // KIB C (Gedung & Bangunan) - Full CRUD untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kib_c/create', [KIBCController::class, 'create'])->name('kib_c.create');
        Route::post('/kib_c', [KIBCController::class, 'store'])->name('kib_c.store');
        Route::get('/kib_c/{id}/edit', [KIBCController::class, 'edit'])->name('kib_c.edit');
        Route::put('/kib_c/{id}', [KIBCController::class, 'update'])->name('kib_c.update');
        Route::delete('/kib_c/{id}', [KIBCController::class, 'destroy'])->name('kib_c.destroy');
    });

    // KIB C - Lihat (Admin & Kepsek) + Export Excel
    Route::middleware(['role:admin,kepsek'])->group(function () {
        Route::get('/kib_c', [KIBCController::class, 'index'])->name('kib_c.index');
        Route::get('/kib_c/{id}', [KIBCController::class, 'show'])->name('kib_c.show');
        // Export Excel KIB C
        Route::get('/export/kib-c', [KIBCController::class, 'exportExcel'])->name('export.kib-c');
    });

    // ========== BARANG HABIS PAKAI (CRUD FULL) ==========
    Route::resource('barang-habis-pakai', BarangHabisPakaiController::class);
    Route::put('/barang-habis-pakai/{id}/update-bulan', [BarangHabisPakaiController::class, 'updateBulan'])->name('barang-habis-pakai.updateBulan');

    // ========== GURU (HANYA DASHBOARD) ==========
    // Guru hanya bisa akses dashboard, tidak ada route tambahan

    // ========== ROUTE AJAX UNTUK CEK STOK ==========
    // Route untuk cek stok barang per ruangan (untuk Barang Keluar & Mutasi)
    Route::get('/get-stok-ruangan', function (Request $request) {
        $barangId = $request->barang;
        $ruanganId = $request->ruangan;

        $stok = \App\Models\InventarisRuangan::where([
            'id_barang' => $barangId,
            'id_ruangan' => $ruanganId,
        ])->sum('stok_baik');

        return response()->json(['stok' => $stok]);
    })->name('get-stok-ruangan');

    // Route untuk get ruangan yang punya stok (untuk Barang Keluar & Mutasi)
    Route::get('/get-ruangan-with-stok', function (Request $request) {
        $barangId = $request->barang;
        
        $ruangans = \App\Models\InventarisRuangan::where('id_barang', $barangId)
            ->with('ruangan')
            ->get()
            ->filter(function($item) {
                return $item->stok_baik > 0;
            })
            ->map(function($item) {
                return [
                    'id_ruangan' => $item->id_ruangan,
                    'nama_ruangan' => $item->ruangan->nama_ruangan ?? 'Ruangan Dihapus',
                    'stok' => $item->stok_baik,
                ];
            })
            ->values();

        return response()->json($ruangans);
    })->name('get-ruangan-with-stok');
});

// ========== ROUTE UNTUK CEK STOK (AJAX) ==========
Route::get('/get-stok-ruangan-old', function (Request $request) {
    $barangId = $request->barang;
    $ruanganId = $request->ruangan;

    $stok = \App\Models\InventarisRuangan::where([
        'id_barang' => $barangId,
        'id_ruangan' => $ruanganId,
    ])->sum('stok_baik');

    return response()->json(['stok' => $stok]);
})->name('get-stok-ruangan-old');