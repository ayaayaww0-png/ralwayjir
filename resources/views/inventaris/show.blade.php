<!DOCTYPE html>
<html>
<head>
    <title>Detail Inventaris Ruangan</title>
</head>
<body>
    <h1>Detail Inventaris Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('inventaris.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $inventaris->id_inventaris }}</td>
        </tr>
        <tr>
            <th>Barang</th>
            <td>{{ $inventaris->barang->nama_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $inventaris->barang->kode_barang ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ruangan</th>
            <td>{{ $inventaris->ruangan->nama_ruangan ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Supplier</th>
            <td>{{ $inventaris->supplier->nama_supplier ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Stok</th>
            <td>{{ $inventaris->stok }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>
                @if($inventaris->kondisi == 'BAIK')
                    <span style="color: green;"> BAIK</span>
                @elseif($inventaris->kondisi == 'RUSAK')
                    <span style="color: red;"> RUSAK</span>
                @else
                    <span style="color: orange;"> HILANG</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $inventaris->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $inventaris->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>