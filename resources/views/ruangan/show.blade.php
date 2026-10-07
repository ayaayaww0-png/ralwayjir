@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Ruangan</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap ruangan.</p>
    </div>
</div>

{{-- INFO RUANGAN --}}
<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $ruangan->id_ruangan }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Nama Ruangan</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $ruangan->nama_ruangan }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $ruangan->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $ruangan->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 600;">{{ $ruangan->inventarisRuangan->count() }} item</td>
        </tr>
    </table>
</div>

{{-- DAFTAR BARANG DI RUANGAN --}}
<h3 style="color: #0f2b4a; font-size: 17px; margin-bottom: 12px;">📦 Daftar Barang di Ruangan Ini</h3>

@if($ruangan->inventarisRuangan->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                    <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Barang</th>
                    <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Harga Satuan</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">BAIK</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">RUSAK</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">HILANG</th>
                    <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Total</th>
                    <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                @endphp
                @foreach($ruangan->inventarisRuangan as $index => $inventaris)
                    @php
                        $totalStok = $inventaris->stok_baik + $inventaris->stok_rusak + $inventaris->stok_hilang;
                        $totalNilai = $inventaris->barang->harga * $totalStok;
                        $grandTotal += $totalNilai;
                    @endphp
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                        <td style="padding: 8px 12px; font-weight: 500;">{{ $inventaris->barang->nama_barang ?? '-' }}</td>
                        <td style="padding: 8px 12px; text-align: right;">Rp {{ number_format($inventaris->barang->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #16a34a; font-weight: 600;">{{ $inventaris->stok_baik }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #dc2626; font-weight: 600;">{{ $inventaris->stok_rusak }}</td>
                        <td style="padding: 8px 12px; text-align: center; color: #f59e0b; font-weight: 600;">{{ $inventaris->stok_hilang }}</td>
                        <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $totalStok }}</td>
                        <td style="padding: 8px 12px; text-align: right; font-weight: 600; color: #0f2b4a;">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                {{-- TOTAL KESELURUHAN --}}
                <tr style="background: #f1f4f9; font-weight: 700; border-top: 2px solid #0f2b4a;">
                    <td colspan="7" style="padding: 10px 12px; text-align: right; font-size: 15px;">TOTAL KESELURUHAN</td>
                    <td style="padding: 10px 12px; text-align: right; font-size: 15px; color: #0f2b4a;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <div style="background: #f8fafc; padding: 30px; text-align: center; border-radius: 12px; color: #6b7a8f;">
        📭 Belum ada barang di ruangan ini.
    </div>
@endif

{{-- TOMBOL KEMBALI --}}
<div style="margin-top: 25px;">
    <a href="{{ route('ruangan.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection