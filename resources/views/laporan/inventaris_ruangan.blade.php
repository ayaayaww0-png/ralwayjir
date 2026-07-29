<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris per Ruangan</title>
</head>
<body>
    <h1>🏢 Laporan Inventaris per Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('laporan.index') }}">Kembali ke Menu Laporan</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('laporan.inventaris-ruangan') }}" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px;">
        <h3>Filter:</h3>
        
        <div>
            <label>Ruangan:</label>
            <select name="ruangan">
                <option value="">Semua</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id_ruangan }}" {{ request('ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Kondisi:</label>
            <select name="kondisi">
                <option value="">Semua</option>
                <option value="BAIK" {{ request('kondisi') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
                <option value="RUSAK" {{ request('kondisi') == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
                <option value="HILANG" {{ request('kondisi') == 'HILANG' ? 'selected' : '' }}>HILANG</option>
            </select>
        </div>
        <br>
        
        <button type="submit">Filter</button>
        <button type="submit" name="cetak_pdf" value="1">Cetak PDF</button>
        <a href="{{ route('laporan.inventaris-ruangan') }}">Reset</a>
    </form>

    {{-- Tabel --}}
    <table border="1" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Ruangan</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        @if($item->kondisi == 'BAIK')
                            <span style="color: green;">BAIK</span>
                        @elseif($item->kondisi == 'RUSAK')
                            <span style="color: red;">RUSAK</span>
                        @else
                            <span style="color: orange;">HILANG</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>