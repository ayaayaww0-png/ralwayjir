<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris per Ruangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
        .baik { color: green; font-weight: bold; }
        .rusak { color: red; font-weight: bold; }
        .hilang { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN INVENTARIS PER RUANGAN</h1>
        <p>SMK NEGERI 2 PADANG PANJANG</p>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
        <hr>
    </div>

    <table>
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
                            <span class="baik">BAIK</span>
                        @elseif($item->kondisi == 'RUSAK')
                            <span class="rusak">RUSAK</span>
                        @else
                            <span class="hilang">HILANG</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $inventaris->count() }}</p>
        <p>Dicetak oleh: SMK NEGERI 2 PADANG PANJANG</p>
    </div>
</body>
</html>