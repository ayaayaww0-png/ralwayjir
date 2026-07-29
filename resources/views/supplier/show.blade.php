<!DOCTYPE html>
<html>
<head>
    <title>Detail Supplier</title>
</head>
<body>
    <h1>Detail Supplier</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('supplier.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $supplier->id_supplier }}</td>
        </tr>
        <tr>
            <th>Nama Supplier</th>
            <td>{{ $supplier->nama_supplier }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $supplier->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $supplier->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Jumlah Barang Masuk</th>
            <td>{{ $supplier->barangMasuk->count() }} transaksi</td>
        </tr>
        <tr>
            <th>Jumlah Inventaris</th>
            <td>{{ $supplier->inventarisRuangan->count() }} item</td>
        </tr>
    </table>

    <br>
    <a href="{{ route('supplier.index') }}">Kembali ke Daftar</a>
</body>
</html>