<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang Keluar</title>
</head>
<body>
    <h1>Detail Barang Keluar</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang-keluar.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $barangKeluar->id_keluar }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Barang</th>
            <td>{{ $barangKeluar->barang->nama_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $barangKeluar->barang->kode_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ruangan Asal</th>
            <td>{{ $barangKeluar->ruangan->nama_ruangan ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $barangKeluar->jumlah }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $barangKeluar->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $barangKeluar->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>