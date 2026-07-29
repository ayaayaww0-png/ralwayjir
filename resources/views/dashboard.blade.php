<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistem Inventaris Sekolah</title>
</head>
<body>
    <h1>Dashboard Sistem Inventaris Sekolah</h1>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('kategori.index') }}">Kategori</a> |
        <a href="{{ route('supplier.index') }}">Supplier</a> |
        <a href="{{ route('ruangan.index') }}">Ruangan</a> |
        <a href="{{ route('barang.index') }}">Barang</a> |
        <a href="{{ route('inventaris.index') }}">Inventaris</a> |
        <a href="{{ route('barang-masuk.index') }}">Barang Masuk</a> |
        <a href="{{ route('barang-keluar.index') }}">Barang Keluar</a> |
        <a href="{{ route('mutasi-barang.index') }}">Mutasi Barang</a> |
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>

    <hr>

    {{-- GREETING --}}
    <h2>👋 Halo, User!</h2>
    <p>Hari ini: {{ date('l, d-m-Y') }}</p>

    <hr>

    {{-- CARD STATISTIK --}}
    <h3>📊 Statistik</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>📦 Total Barang</th>
            <th>🏷️ Total Kategori</th>
            <th>🏢 Total Ruangan</th>
            <th>⚠️ Stok Menipis</th>
        </tr>
        <tr>
            <td>{{ $totalBarang }}</td>
            <td>{{ $totalKategori }}</td>
            <td>{{ $totalRuangan }}</td>
            <td>{{ $totalStokMenipis }}</td>
        </tr>
    </table>

    <br>

    {{-- ALERT STOK MENIPIS --}}
    <h3>⚠️ Alert Stok Menipis</h3>
    @if($stokMenipis->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok Saat Ini</th>
                    <th>Minimal Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokMenipis as $barang)
                    <tr>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->stok_total }}</td>
                        <td>{{ $barang->min_stok }}</td>
                        <td>
                            @if($barang->stok_total <= 0)
                                <span style="color: red;">HABIS</span>
                            @else
                                <span style="color: orange;">MENIPIS</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: green;">Semua barang aman, stok mencukupi.</p>
    @endif

    <br>

    {{-- GRAFIK STOK PER KATEGORI --}}
    <h3>Grafik Stok per Kategori</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total Stok</th>
                <th>Grafik</th>
            </tr>
        </thead>
        <tbody>
            @php
                $maxStok = collect($stokPerKategori)->max('total') ?: 1;
            @endphp
            @foreach($stokPerKategori as $item)
                <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['total'] }}</td>
                    <td>
                        <div style="background-color: #4CAF50; width: {{ ($item['total'] / $maxStok) * 300 }}px; height: 20px; display: inline-block; text-align: center; color: white;">
                            {{ $item['total'] }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    {{-- KONDISI BARANG --}}
    <h3>📊 Kondisi Barang</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th style="color: green;">✅ BAIK</th>
            <th style="color: red;">❌ RUSAK</th>
            <th style="color: orange;">⚠️ HILANG</th>
        </tr>
        <tr>
            <td>{{ $kondisiBaik }}</td>
            <td>{{ $kondisiRusak }}</td>
            <td>{{ $kondisiHilang }}</td>
        </tr>
    </table>

    <br>

    {{-- TRANSAKSI TERBARU --}}
    <h3>📋 Transaksi Terbaru</h3>
    @if($transaksiTerbaru->count() > 0)
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Barang</th>
                    <th>Ruangan</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksiTerbaru as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                        <td>{{ $item['jenis'] }}</td>
                        <td>{{ $item['barang'] }}</td>
                        <td>{{ $item['ruangan'] }}</td>
                        <td>{{ $item['supplier'] }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada transaksi.</p>
    @endif

</body>
</html>