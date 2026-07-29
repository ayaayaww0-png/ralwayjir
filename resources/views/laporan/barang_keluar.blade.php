<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Keluar</title>
</head>
<body>
    <h1>📤 Laporan Barang Keluar</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('laporan.index') }}">Kembali ke Menu Laporan</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('laporan.barang-keluar') }}" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px;">
        <h3>Filter:</h3>
        
        <div>
            <label>Dari Tanggal:</label>
            <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
        </div>
        <br>
        
        <div>
            <label>Sampai Tanggal:</label>
            <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
        </div>
        <br>
        
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
        
        <button type="submit">Filter</button>
        <button type="submit" name="cetak_pdf" value="1">Cetak PDF</button>
        <a href="{{ route('laporan.barang-keluar') }}">Reset</a>
    </form>

    {{-- Tabel --}}
    <table border="1" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Ruangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangKeluars as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>