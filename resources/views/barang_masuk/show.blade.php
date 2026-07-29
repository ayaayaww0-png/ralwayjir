<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang Masuk</title>
</head>
<body>
    <h1>Detail Barang Masuk</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang-masuk.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $barangMasuk->id_masuk }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Barang</th>
            <td>{{ $barangMasuk->barang->nama_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $barangMasuk->barang->kode_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Supplier</th>
            <td>{{ $barangMasuk->supplier->nama_supplier ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ruangan Tujuan</th>
            <td>{{ $barangMasuk->ruangan->nama_ruangan ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $barangMasuk->jumlah }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $barangMasuk->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $barangMasuk->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>

    <br>
    <a href="{{ route('barang-masuk.index') }}">Kembali ke Daftar</a>
</body>
</html>