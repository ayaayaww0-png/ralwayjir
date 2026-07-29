<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN MUTASI BARANG</h1>
        <p>SMK NEGERI 2 PADANG PANJANG</p>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Ruangan Asal</th>
                <th>Ruangan Tujuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutasiBarangs as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->ruanganAsal->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->ruanganTujuan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $mutasiBarangs->count() }}</p>
        <p>Dicetak oleh: SMK NEGERI 2 PADANG PANJANG</p>
    </div>
</body>
</html>