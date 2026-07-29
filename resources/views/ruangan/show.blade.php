<!DOCTYPE html>
<html>
<head>
    <title>Detail Ruangan</title>
</head>
<body>
    <h1>Detail Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('ruangan.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $ruangan->id_ruangan }}</td>
        </tr>
        <tr>
            <th>Nama Ruangan</th>
            <td>{{ $ruangan->nama_ruangan }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $ruangan->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $ruangan->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Jumlah Inventaris</th>
            <td>{{ $ruangan->inventarisRuangan->count() }} item</td>
        </tr>
        <tr>
            <th>Jumlah Barang Masuk</th>
            <td>{{ $ruangan->barangMasuk->count() }} transaksi</td>
        </tr>
        <tr>
            <th>Jumlah Barang Keluar</th>
            <td>{{ $ruangan->barangKeluar->count() }} transaksi</td>
        </tr>
        <tr>
            <th>Jumlah Mutasi (Asal)</th>
            <td>{{ $ruangan->mutasiAsal->count() }} transaksi</td>
        </tr>
        <tr>
            <th>Jumlah Mutasi (Tujuan)</th>
            <td>{{ $ruangan->mutasiTujuan->count() }} transaksi</td>
        </tr>
    </table>

    <h3>Daftar Inventaris di Ruangan Ini:</h3>
    @if($ruangan->inventarisRuangan->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Supplier</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangan->inventarisRuangan as $inventaris)
                    <tr>
                        <td>{{ $inventaris->barang->nama_barang ?? 'N/A' }}</td>
                        <td>{{ $inventaris->supplier->nama_supplier ?? 'N/A' }}</td>
                        <td>{{ $inventaris->stok }}</td>
                        <td>{{ $inventaris->kondisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada inventaris di ruangan ini.</p>
    @endif

    <br>
    <a href="{{ route('ruangan.index') }}">Kembali ke Daftar</a>
</body>
</html>