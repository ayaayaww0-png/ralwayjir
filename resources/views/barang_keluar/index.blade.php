<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang Keluar</title>
</head>
<body>
    <h1>Daftar Barang Keluar</h1>

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

    <a href="{{ route('barang-keluar.create') }}">Tambah Barang Keluar</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Ruangan</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangKeluars as $item)
                <tr>
                    <td>{{ $item->id_keluar }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? 'N/A' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        <a href="{{ route('barang-keluar.show', $item->id_keluar) }}">Detail</a> |
                        <a href="{{ route('barang-keluar.edit', $item->id_keluar) }}">Edit</a> |
                        <form action="{{ route('barang-keluar.destroy', $item->id_keluar) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada transaksi barang keluar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>