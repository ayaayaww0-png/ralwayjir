<!DOCTYPE html>
<html>
<head>
    <title>Daftar Inventaris Ruangan</title>
</head>
<body>
    <h1>Daftar Inventaris Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('dashboard') }}">Dashboard</a> |
        <a href="{{ route('kategori.index') }}">Kategori</a> |
        <a href="{{ route('supplier.index') }}">Supplier</a> |
        <a href="{{ route('ruangan.index') }}">Ruangan</a> |
        <a href="{{ route('barang.index') }}">Barang</a> |
        <a href="{{ route('inventaris.index') }}">Inventaris</a> |
        <a href="{{ route('barang-masuk.index') }}">Barang Masuk</a> |
        <a href="{{ route('barang-keluar.index') }}">Barang Keluar</a> |
        <a href="{{ route('mutasi-barang.index') }}">Mutasi Barang</a>
    </div>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('inventaris.create') }}">Tambah Inventaris Baru</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Barang</th>
                <th>Ruangan</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $item)
                <tr>
                    <td>{{ $item->id_inventaris }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? 'N/A' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? 'N/A' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        @if($item->kondisi == 'BAIK')
                            <span style="color: green;"> BAIK</span>
                        @elseif($item->kondisi == 'RUSAK')
                            <span style="color: red;"> RUSAK</span>
                        @else
                            <span style="color: orange;"> HILANG</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('inventaris.show', $item->id_inventaris) }}">Detail</a> |
                        <a href="{{ route('inventaris.edit', $item->id_inventaris) }}">Edit</a> |
                        <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus inventaris ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada inventaris ruangan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>