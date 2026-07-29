<!DOCTYPE html>
<html>
<head>
    <title>Daftar Supplier</title>
</head>
<body>
    <h1>Daftar Supplier</h1>

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

    <a href="{{ route('supplier.create') }}">Tambah Supplier Baru</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id_supplier }}</td>
                    <td>{{ $supplier->nama_supplier }}</td>
                    <td>{{ $supplier->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('supplier.show', $supplier->id_supplier) }}">Detail</a> |
                        <a href="{{ route('supplier.edit', $supplier->id_supplier) }}">Edit</a> |
                        <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus supplier ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada supplier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>