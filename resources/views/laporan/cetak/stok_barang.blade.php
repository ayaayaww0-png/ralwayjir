<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            margin: 30px 40px;
            padding: 0;
        }
        .kop { text-align: center; margin-bottom: 20px; }
        .kop img { width: 100%; max-width: 750px; height: auto; }
        .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .subtitle { text-align: center; font-size: 12px; margin-bottom: 15px; }
        .info-surat { margin-bottom: 12px; }
        .info-surat .nomor { font-size: 12px; }
        .info-surat .perihal { font-size: 12px; font-weight: bold; }
        hr { border: 0.5px solid #000; margin: 6px 0; }
        .content p { text-align: justify; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 4px 8px; text-align: center; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .footer { margin-top: 25px; text-align: center; font-size: 11px; border-top: 1px solid #ccc; padding-top: 8px; }
        .footer .city-date { font-style: italic; }
        .grand-total { background-color: #f0f0f0; font-weight: bold; }
    </style>
</head>
<body>

    <div class="kop">
        <img src="{{ public_path('images/kop-surat.png') }}" alt="Kop Surat SMKN 2 Padang Panjang">
    </div>

    <div class="title">LAPORAN STOK BARANG</div>
    <div class="subtitle">Sistem Inventaris Barang Sekolah</div>

    <div class="info-surat">
        <div class="nomor"><strong>Nomor :</strong> 800 / 576 / SMKN.02PP / VIII / 2026</div>
        <div class="perihal"><strong>Perihal :</strong> Laporan Stok Barang</div>
        <hr>
    </div>

    <div class="content">
        <p>Dengan hormat,</p>
        <p>Berikut ini adalah data stok barang di SMKN 2 Padang Panjang per tanggal <strong>{{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</strong>.</p>

        @php
            $grandTotal = 0;
        @endphp

        <table>
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:12%">Kode</th>
                    <th style="width:15%" class="text-left">Nama Barang</th>
                    <th style="width:15%" class="text-left">Kategori</th>
                    <th style="width:7%">Stok</th>
                    <th style="width:15%" class="text-right">Harga Satuan</th>
                    <th style="width:17%" class="text-right">Total Nilai</th>
                    <th style="width:10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $barang)
                    @php
                        $totalNilai = $barang->stok_total * $barang->harga;
                        $grandTotal += $totalNilai;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td class="text-left">{{ $barang->nama_barang }}</td>
                        <td class="text-left">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $barang->stok_total }}</td>
                        <td class="text-right">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                        <td>
                            @if($barang->stok_total <= 0) HABIS
                            @elseif($barang->stok_total <= $barang->min_stok) MENIPIS
                            @else AMAN @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center;">Tidak ada data.</td></tr>
                @endforelse
                @if($barangs->count() > 0)
                    <tr class="grand-total">
                        <td colspan="6" style="text-align:right;">TOTAL KESELURUHAN</td>
                        <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="city-date">Padang Panjang, {{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
        <div style="margin-top:4px;">Dicetak oleh: Sistem Inventaris SMKN 2 Padang Panjang</div>
    </div>

</body>
</html>