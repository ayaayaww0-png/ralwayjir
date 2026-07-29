<!DOCTYPE html>
<html>
<head>
    <title>Detail Kategori</title>
</head>
<body>
    <h1>Detail Kategori</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $kategori->id_kategori }}</td>
        </tr>
        <tr>
            <th>Nama Kategori</th>
            <td>{{ $kategori->nama_kategori }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $kategori->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $kategori->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Jumlah Barang</th>
            <td>{{ $kategori->barang->count() }} barang</td>
        </tr>
    </table>

    <br>
    <a href="{{ route('kategori.index') }}">Kembali ke Daftar</a>
</body>
</html>