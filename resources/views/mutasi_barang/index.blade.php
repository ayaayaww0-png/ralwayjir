<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mutasi Barang</title>
</head>
<body>
    <h1>Daftar Mutasi Barang</h1>

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

    <a href="{{ route('mutasi-barang.create') }}">Tambah Mutasi Barang</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Dari Ruangan</th>
                <th>Ke Ruangan</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutasiBarangs as $item)
                <tr>
                    <td>{{ $item->id_mutasi }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $item->ruanganAsal->nama_ruangan ?? 'N/A' }}</td>
                    <td>{{ $item->ruanganTujuan->nama_ruangan ?? 'N/A' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        <a href="{{ route('mutasi-barang.show', $item->id_mutasi) }}">Detail</a> |
                        <a href="{{ route('mutasi-barang.edit', $item->id_mutasi) }}">Edit</a> |
                        <form action="{{ route('mutasi-barang.destroy', $item->id_mutasi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus mutasi ini? Stok akan dikembalikan.')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada transaksi mutasi barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>