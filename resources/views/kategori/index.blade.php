<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kategori</title>
</head>
<body>
    <h1>Daftar Kategori</h1>

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

    <a href="{{ route('kategori.create') }}">Tambah Kategori Baru</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->id_kategori }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('kategori.show', $kategori->id_kategori) }}">Detail</a> |
                        <a href="{{ route('kategori.edit', $kategori->id_kategori) }}">Edit</a> |
                        <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>