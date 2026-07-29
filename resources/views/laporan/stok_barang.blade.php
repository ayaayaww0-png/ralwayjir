<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
</head>
<body>
    <h1>📦 Laporan Stok Barang</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('laporan.index') }}">Kembali ke Menu Laporan</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('laporan.stok-barang') }}" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px;">
        <h3>Filter:</h3>
        
        <div>
            <label>Kategori:</label>
            <select name="kategori">
                <option value="">Semua</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Status:</label>
            <select name="status">
                <option value="">Semua</option>
                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>AMAN</option>
                <option value="menipis" {{ request('status') == 'menipis' ? 'selected' : '' }}>MENIPIS</option>
                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>HABIS</option>
            </select>
        </div>
        <br>
        
        <div>
            <label>Cari:</label>
            <input type="text" name="search" placeholder="Cari kode/nama barang" value="{{ request('search') }}">
        </div>
        <br>
        
        <button type="submit">Filter</button>
        <button type="submit" name="cetak_pdf" value="1">Cetak PDF</button>
        <a href="{{ route('laporan.stok-barang') }}">Reset</a>
    </form>

    {{-- Tabel --}}
    <table border="1" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok Total</th>
                <th>Min Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
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
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <p>Total Barang: {{ $barangs->count() }}</p>
</body>
</html>