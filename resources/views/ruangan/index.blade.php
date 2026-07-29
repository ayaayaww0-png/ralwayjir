<!DOCTYPE html>
<html>
<head>
    <title>Daftar Ruangan</title>
</head>
<body>
    <h1>Daftar Ruangan</h1>

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

    <a href="{{ route('ruangan.create') }}">Tambah Ruangan Baru</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Ruangan</th>
                <th>Dibuat</th>
                <th>Jumlah Inventaris</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruangans as $ruangan)
                <tr>
                    <td>{{ $ruangan->id_ruangan }}</td>
                    <td>{{ $ruangan->nama_ruangan }}</td>
                    <td>{{ $ruangan->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $ruangan->inventarisRuangan->count() }} item</td>
                    <td>
                        <a href="{{ route('ruangan.show', $ruangan->id_ruangan) }}">Detail</a> |
                        <a href="{{ route('ruangan.edit', $ruangan->id_ruangan) }}">Edit</a> |
                        <form action="{{ route('ruangan.destroy', $ruangan->id_ruangan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus ruangan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada ruangan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>