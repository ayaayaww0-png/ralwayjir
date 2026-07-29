<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
</head>
<body>
    <h1>Daftar Barang</h1>

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

    <a href="{{ route('barang.create') }}">Tambah Barang Baru</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok Total</th>
                <th>Min Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $barang)
                <tr>
                    <td>{{ $barang->id_barang }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $barang->stok_total }}</td>
                    <td>{{ $barang->min_stok }}</td>
                    <td>
                        @if($barang->stok_total <= 0)
                            <span style="color: red;">HABIS</span>
                        @elseif($barang->stok_total <= $barang->min_stok)
                            <span style="color: orange;">MENIPIS</span>
                        @else
                            <span style="color: green;">AMAN</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('barang.show', $barang->id_barang) }}">Detail</a> |
                        <a href="{{ route('barang.edit', $barang->id_barang) }}">Edit</a> |
                        <form action="{{ route('barang.destroy', $barang->id_barang) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>