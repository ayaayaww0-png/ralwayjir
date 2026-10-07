@extends('layouts.app')

@section('title', 'Detail KIB A - Tanah')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Tanah</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap tanah.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->id_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->kode_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Nama Tanah</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Register</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->register ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Luas (M2)</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ number_format($barang->luas ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Tahun Perolehan</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->tahun ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Lokasi / Alamat</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Status Tanah</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->status_tanah ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Tanah</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->kode_tanah ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Asal Usul</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barang->asal_usul ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Harga</td>
            <td style="padding: 10px 0; color: #0f2b4a; font-weight: 700;">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barang->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('kib_a.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection