@extends('layouts.app')

@section('title', 'Dashboard - Sistem Inventaris')

@section('content')
    <style>
        /* ===== STATISTIK GRID ===== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        /* ===== 2 KOLOM GRID ===== */
        .two-col-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ===== RESPONSIVE: TABLET & HP ===== */
        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .stat-grid > div {
                padding: 15px !important;
            }

            .stat-grid > div > div:first-child {
                font-size: 24px !important;
            }

            .stat-grid > div > div:last-child {
                font-size: 12px;
            }

            .two-col-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .stat-grid > div {
                padding: 12px !important;
            }

            .stat-grid > div > div:first-child {
                font-size: 20px !important;
            }

            .stat-grid > div > div:last-child {
                font-size: 11px;
            }
        }

        /* ===== TABEL RESPONSIVE ===== */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            min-width: 500px;
        }
    </style>

    {{-- STATISTIK --}}
    <div class="stat-grid">
        <div style="background: hsl(214, 95%, 93%); padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 30px; font-weight: 700; color: #1e40af;">{{ $totalBarang }}</div>
            <div style="color: #1e40af; font-weight: 500;">Total Barang</div>
        </div>
        <div style="background: #dcfce7; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 30px; font-weight: 700; color: #166534;">{{ $totalKategori }}</div>
            <div style="color: #166534; font-weight: 500;">Kategori</div>
        </div>
        <div style="background: #fef3c7; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 30px; font-weight: 700; color: #92400e;">{{ $totalRuangan }}</div>
            <div style="color: #92400e; font-weight: 500;">Ruangan</div>
        </div>
        <div style="background: #fee2e2; padding: 20px; border-radius: 12px; text-align: center;">
            <div style="font-size: 30px; font-weight: 700; color: #991b1b;">{{ $totalStokMenipis }}</div>
            <div style="color: #991b1b; font-weight: 500;">Stok Menipis</div>
        </div>
    </div>

    {{-- ALERT STOK MENIPIS --}}
    <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px;">
        <h3 style="color: #92400e; margin-bottom: 10px;">⚠️ ALERT STOK MENIPIS</h3>
        @if($stokMenipis->count() > 0)
            <ul style="list-style: none; padding: 0;">
                @foreach($stokMenipis as $barang)
                    <li style="padding: 4px 0; color: #78350f;">
                        {{ $barang->nama_barang }} : {{ $barang->stok_total }} (Min {{ $barang->min_stok }})
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color: #166534;">✅ Semua barang aman, stok mencukupi.</p>
        @endif
    </div>

    {{-- 2 KOLOM: STOK PER KATEGORI & KONDISI BARANG --}}
    <div class="two-col-grid">
        {{-- STOK PER KATEGORI --}}
        <div style="background: #f8fafc; padding: 20px; border-radius: 12px;">
            <h3 style="color: #0f2b4a; margin-bottom: 15px;">📊 STOK PER KATEGORI</h3>
            @php
                $maxStok = collect($stokPerKategori)->max('total') ?? 0;
            @endphp
            @foreach($stokPerKategori as $item)
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                    <span>{{ $item['nama'] }}</span>
                    <div style="display: flex; align-items: center; gap: 10px; width: 60%;">
                        <div style="flex: 1; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $maxStok > 0 ? ($item['total'] / $maxStok) * 100 : 0 }}%; background: #3b82f6; border-radius: 10px;"></div>
                        </div>
                        <span style="font-weight: 600; color: #0f2b4a; min-width: 40px; text-align: right;">{{ $item['total'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- KONDISI BARANG --}}
        <div style="background: #f8fafc; padding: 20px; border-radius: 12px;">
            <h3 style="color: #0f2b4a; margin-bottom: 15px;">📊 KONDISI BARANG</h3>
            <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                <span style="color: green;">✅ BAIK</span>
                <span style="font-weight: 600; color: green;">{{ $kondisiBaik }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                <span style="color: red;">❌ RUSAK</span>
                <span style="font-weight: 600; color: red;">{{ $kondisiRusak }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                <span style="color: orange;">⚠️ HILANG</span>
                <span style="font-weight: 600; color: orange;">{{ $kondisiHilang }}</span>
            </div>
        </div>
    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div style="margin-top: 25px; background: #f8fafc; padding: 20px; border-radius: 12px;">
        <h3 style="color: #0f2b4a; margin-bottom: 15px;">📋 Transaksi Terbaru</h3>
        @if($transaksiTerbaru->count() > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr style="background: #f1f4f9;">
                            <th style="padding: 8px 12px; text-align: left;">Tanggal</th>
                            <th style="padding: 8px 12px; text-align: left;">Jenis</th>
                            <th style="padding: 8px 12px; text-align: left;">Barang</th>
                            <th style="padding: 8px 12px; text-align: left;">Ruangan</th>
                            <th style="padding: 8px 12px; text-align: center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $item)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 6px 12px;">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                                <td style="padding: 6px 12px;">{{ $item['jenis'] }}</td>
                                <td style="padding: 6px 12px; font-weight: 500;">{{ $item['barang'] }}</td>
                                <td style="padding: 6px 12px;">{{ $item['ruangan'] }}</td>
                                <td style="padding: 6px 12px; text-align: center; font-weight: 600;">{{ $item['jumlah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color: #6b7a8f;">Belum ada transaksi.</p>
        @endif
    </div>
@endsection