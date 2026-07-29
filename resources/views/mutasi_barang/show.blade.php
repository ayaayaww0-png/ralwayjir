<!DOCTYPE html>
<html>
<head>
    <title>Detail Mutasi Barang</title>
</head>
<body>
    <h1>Detail Mutasi Barang</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('mutasi-barang.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $mutasiBarang->id_mutasi }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $mutasiBarang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Barang</th>
            <td>{{ $mutasiBarang->barang->nama_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $mutasiBarang->barang->kode_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ruangan Asal</th>
            <td>{{ $mutasiBarang->ruanganAsal->nama_ruangan ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ruangan Tujuan</th>
            <td>{{ $mutasiBarang->ruanganTujuan->nama_ruangan ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $mutasiBarang->jumlah }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $mutasiBarang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $mutasiBarang->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>