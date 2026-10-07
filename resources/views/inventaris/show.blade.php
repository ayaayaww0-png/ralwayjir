@extends('layouts.app')

@section('title', 'Detail Inventaris')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Inventaris</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap inventaris.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    @php
        $totalStok = $inventaris->stok_baik + $inventaris->stok_rusak + $inventaris->stok_hilang;
    @endphp
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $inventaris->id_inventaris }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $inventaris->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $inventaris->barang->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Ruangan</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $inventaris->ruangan->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Stok BAIK</td>
            <td style="padding: 10px 0; color: #16a34a; font-weight: 600;">{{ $inventaris->stok_baik }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Stok RUSAK</td>
            <td style="padding: 10px 0; color: #dc2626; font-weight: 600;">{{ $inventaris->stok_rusak }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Stok HILANG</td>
            <td style="padding: 10px 0; color: #f59e0b; font-weight: 600;">{{ $inventaris->stok_hilang }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Total Stok</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 600;">{{ $totalStok }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $inventaris->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $inventaris->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('inventaris.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection