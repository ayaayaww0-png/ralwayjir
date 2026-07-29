<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang</title>
</head>
<body>
    <h1>Detail Barang</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang.index') }}">Kembali ke Daftar</a>
    </div>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <td>{{ $barang->id_barang }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $barang->kode_barang }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Stok Total</th>
            <td>
                {{ $barang->stok_total }}
                @if($barang->stok_total <= 0)
                    <span style="color: red;">(HABIS)</span>
                @elseif($barang->stok_total <= $barang->min_stok)
                    <span style="color: orange;">(MENIPIS)</span>
                @else
                    <span style="color: green;">(AMAN)</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Minimal Stok</th>
            <td>{{ $barang->min_stok }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $barang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate</th>
            <td>{{ $barang->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>

    <h3>Distribusi Stok per Ruangan:</h3>
    @if($barang->inventarisRuangan->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Ruangan</th>
                    <th>Supplier</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->inventarisRuangan as $inventaris)
                    <tr>
                        <td>{{ $inventaris->ruangan->nama_ruangan ?? 'N/A' }}</td>
                        <td>{{ $inventaris->supplier->nama_supplier ?? 'N/A' }}</td>
                        <td>{{ $inventaris->stok }}</td>
                        <td>{{ $inventaris->kondisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada inventaris untuk barang ini.</p>
    @endif

    <h3>Riwayat Transaksi:</h3>
    <h4>Barang Masuk ({{ $barang->barangMasuk->count() }}):</h4>
    @if($barang->barangMasuk->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Ruangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->barangMasuk as $masuk)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($masuk->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $masuk->supplier->nama_supplier ?? 'N/A' }}</td>
                        <td>{{ $masuk->ruangan->nama_ruangan ?? 'N/A' }}</td>
                        <td>{{ $masuk->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada transaksi masuk.</p>
    @endif

    <h4>Barang Keluar ({{ $barang->barangKeluar->count() }}):</h4>
    @if($barang->barangKeluar->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Ruangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->barangKeluar as $keluar)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($keluar->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $keluar->ruangan->nama_ruangan ?? 'N/A' }}</td>
                        <td>{{ $keluar->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada transaksi keluar.</p>
    @endif

    <h4>Mutasi Barang ({{ $barang->mutasiBarang->count() }}):</h4>
    @if($barang->mutasiBarang->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang->mutasiBarang as $mutasi)
                    <tr>
                        <td>{{ $mutasi->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $mutasi->ruanganAsal->nama_ruangan ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($mutasi->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $mutasi->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada transaksi mutasi.</p>
    @endif

    <br>
    <a href="{{ route('barang.index') }}">Kembali ke Daftar</a>
</body>
</html>