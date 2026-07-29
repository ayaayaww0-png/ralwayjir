<!DOCTYPE html>
<html>
<head>
    <title>Laporan - Sistem Inventaris Sekolah</title>
</head>
<body>
    <h1>📊 Laporan Sistem Inventaris Sekolah</h1>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('dashboard') }}">Dashboard</a> |
        <a href="{{ route('kategori.index') }}">Kategori</a> |
        <a href="{{ route('supplier.index') }}">Supplier</a> |
        <a href="{{ route('ruangan.index') }}">Ruangan</a> |
        <a href="{{ route('barang.index') }}">Barang</a> |
        <a href="{{ route('inventaris.index') }}">Inventaris</a> |
        <a href="{{ route('barang-masuk.index') }}">Barang Masuk</a> |
        <a href="{{ route('barang-keluar.index') }}">Barang Keluar</a> |
        <a href="{{ route('mutasi-barang.index') }}">Mutasi Barang</a> |
        <a href="{{ route('laporan.index') }}">Laporan</a>
    </div>

    <hr>

    <h2>Pilih Jenis Laporan:</h2>

    <table border="1" cellpadding="15">
        <tr>
            <td>
                <a href="{{ route('laporan.stok-barang') }}">
                    <h3>📦 Laporan Stok Barang</h3>
                    <p>Lihat seluruh stok barang di sekolah</p>
                </a>
            </td>
            <td>
                <a href="{{ route('laporan.inventaris-ruangan') }}">
                    <h3>🏢 Laporan Inventaris per Ruangan</h3>
                    <p>Lihat stok barang per ruangan & kondisi</p>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{ route('laporan.barang-masuk') }}">
                    <h3>📥 Laporan Barang Masuk</h3>
                    <p>Lihat riwayat barang masuk dari supplier</p>
                </a>
            </td>
            <td>
                <a href="{{ route('laporan.barang-keluar') }}">
                    <h3>📤 Laporan Barang Keluar</h3>
                    <p>Lihat riwayat barang keluar (rusak/hilang)</p>
                </a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{ route('laporan.mutasi-barang') }}">
                    <h3>🔄 Laporan Mutasi Barang</h3>
                    <p>Lihat riwayat pemindahan barang antar ruangan</p>
                </a>
            </td>
        </tr>
    </table>
</body>
</html>