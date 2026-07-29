<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
        .habis { color: red; font-weight: bold; }
        .menipis { color: orange; font-weight: bold; }
        .aman { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STOK BARANG</h1>
        <p>SMK NEGERI 2 PADANG PANJANG</p>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
        <hr>
    </div>

    <table>
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
                            <span class="habis">HABIS</span>
                        @elseif($barang->stok_total <= $barang->min_stok)
                            <span class="menipis">MENIPIS</span>
                        @else
                            <span class="aman">AMAN</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Barang: {{ $barangs->count() }}</p>
        <p>Dicetak oleh: SMK NEGERI 2 PADANG PANJANG</p>
    </div>
</body>
</html>