<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Keluar</title>
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
        .footer { margin-top: 25px; text-align: center; font-size: 11px; border-top: 1px solid #ccc; padding-top: 8px; }
        .footer .city-date { font-style: italic; }
    </style>
</head>
<body>

    <div class="kop">
        <img src="{{ public_path('images/kop-surat.png') }}" alt="Kop Surat SMKN 2 Padang Panjang">
    </div>

    <div class="title">LAPORAN BARANG KELUAR</div>
    <div class="subtitle">Sistem Inventaris Barang Sekolah</div>

    <div class="info-surat">
        <div class="nomor"><strong>Nomor :</strong> 800 / 579 / SMKN.02PP / VIII / 2026</div>
        <div class="perihal"><strong>Perihal :</strong> Laporan Barang Keluar</div>
        <hr>
    </div>

    <div class="content">
        <p>Dengan hormat,</p>
        <p>Berikut ini adalah data barang keluar di SMKN 2 Padang Panjang per tanggal <strong>{{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</strong>.</p>

        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:12%">Tanggal</th>
                    <th style="width:20%" class="text-left">Barang</th>
                    <th style="width:18%" class="text-left">Ruangan</th>
                    <th style="width:8%">Jumlah</th>
                    <th style="width:12%">Jenis</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangKeluars as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td class="text-left">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td class="text-left">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ ucfirst($item->jenis_keluar) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="city-date">Padang Panjang, {{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
        <div style="margin-top:4px;">Dicetak oleh: Sistem Inventaris SMKN 2 Padang Panjang</div>
    </div>

</body>
</html>