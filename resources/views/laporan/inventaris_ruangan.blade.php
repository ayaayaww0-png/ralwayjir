@extends('layouts.app')

@section('title', 'Laporan Inventaris per Ruangan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🏢 Laporan Inventaris per Ruangan</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Stok barang per ruangan & kondisi.</p>
    </div>
    <div>
        <a href="{{ route('laporan.index') }}" style="padding: 8px 20px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; margin-right: 10px;">
            ← Kembali
        </a>
        <button type="submit" form="filter-form" name="cetak_pdf" value="1" style="padding: 8px 20px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
            📄 Cetak PDF
        </button>
    </div>
</div>

{{-- Filter --}}
<form id="filter-form" method="GET" action="{{ route('laporan.inventaris-ruangan') }}" style="background: #f8fafc; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
    <div>
        <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Ruangan:</label>
        <select name="ruangan" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; background: white; margin-left: 5px;">
            <option value="">Semua</option>
            @foreach($ruangans as $ruangan)
                <option value="{{ $ruangan->id_ruangan }}" {{ request('ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                    {{ $ruangan->nama_ruangan }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Kondisi:</label>
        <select name="kondisi" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; background: white; margin-left: 5px;">
            <option value="">Semua</option>
            <option value="BAIK" {{ request('kondisi') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
            <option value="RUSAK" {{ request('kondisi') == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
            <option value="HILANG" {{ request('kondisi') == 'HILANG' ? 'selected' : '' }}>HILANG</option>
        </select>
        <small style="color: #6b7a8f; font-size: 12px;">Filter berdasarkan kondisi barang</small>
    </div>

    <button type="submit" style="padding: 6px 18px; background: #1a4a7a; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Filter</button>
    <a href="{{ route('laporan.inventaris-ruangan') }}" style="padding: 6px 18px; border: 2px solid #dce3ed; border-radius: 6px; text-decoration: none; color: #4a5568; font-weight: 600;">Reset</a>
</form>

{{-- Tabel --}}
<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: #f1f4f9;">
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Barang</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">BAIK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">RUSAK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">HILANG</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Total</th>
                <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $index => $item)
                @php
                    $total = $item->stok_baik + $item->stok_rusak + $item->stok_hilang;
                    $totalNilai = $total * ($item->barang->harga ?? 0);
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td style="padding: 8px 12px;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #16a34a; font-weight: 600;">{{ $item->stok_baik }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #dc2626; font-weight: 600;">{{ $item->stok_rusak }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #f59e0b; font-weight: 600;">{{ $item->stok_hilang }}</td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $total }}</td>
                    <td style="padding: 8px 12px; text-align: right; font-weight: 600;">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada data inventaris.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Data: {{ $inventaris->count() }}
</div>
@endsection