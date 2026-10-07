@extends('layouts.app')

@section('title', 'Detail KIB B - Peralatan & Mesin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Peralatan & Mesin</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap barang.</p>
    </div>
</div>

{{-- INFO BARANG --}}
<div style="max-width: 700px; background: #f8fafc; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px;">
    @php
        $totalStok = $barang->inventarisRuangan->sum('stok_baik') + 
                     $barang->inventarisRuangan->sum('stok_rusak') + 
                     $barang->inventarisRuangan->sum('stok_hilang');
    @endphp
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a; width: 35%;">ID</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $barang->id_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->kode_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Nama Barang</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Kategori</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Total Stok</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 600;">{{ $totalStok }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Harga Satuan</td>
            <td style="padding: 8px 0; color: #1a2a3a;">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Total Nilai</td>
            <td style="padding: 8px 0; color: #0f2b4a; font-weight: 700;">Rp {{ number_format($barang->harga * $totalStok, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 8px 0; color: #6b7a8f;">{{ $barang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 8px 0; color: #6b7a8f;">{{ $barang->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

{{-- DISTRIBUSI STOK PER RUANGAN --}}
<h3 style="color: #0f2b4a; font-size: 16px; margin-bottom: 12px;">📦 Distribusi Stok per Ruangan</h3>

@if($barang->inventarisRuangan->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                    <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">BAIK</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">RUSAK</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">HILANG</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Total</th>
                    <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotalStok = 0;
                    $grandTotalNilai = 0;
                @endphp
                @foreach($barang->inventarisRuangan as $index => $inv)
                    @php
                        $total = $inv->stok_baik + $inv->stok_rusak + $inv->stok_hilang;
                        $nilai = $barang->harga * $total;
                        $grandTotalStok += $total;
                        $grandTotalNilai += $nilai;
                    @endphp
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                        <td style="padding: 8px 12px; font-weight: 500;">{{ $inv->ruangan->nama_ruangan ?? '-' }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #16a34a; font-weight: 600;">{{ $inv->stok_baik }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #dc2626; font-weight: 600;">{{ $inv->stok_rusak }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #f59e0b; font-weight: 600;">{{ $inv->stok_hilang }}</td>
                        <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $total }}</td>
                        <td style="padding: 8px 12px; text-align: right;">Rp {{ number_format($nilai, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr style="background: #f1f4f9; font-weight: 700; border-top: 2px solid #0f2b4a;">
                    <td colspan="5" style="padding: 10px 12px; text-align: right; font-size: 15px;">TOTAL KESELURUHAN</td>
                    <td style="padding: 10px 12px; text-align: center; font-size: 15px;">{{ $grandTotalStok }}</td>
                    <td style="padding: 10px 12px; text-align: right; font-size: 15px; color: #0f2b4a;">Rp {{ number_format($grandTotalNilai, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <div style="background: #f8fafc; padding: 30px; text-align: center; border-radius: 12px; color: #6b7a8f;">
        📭 Belum ada inventaris untuk barang ini.
    </div>
@endif

{{-- TOMBOL KEMBALI --}}
<div style="margin-top: 25px;">
    <a href="{{ route('kib_b.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection