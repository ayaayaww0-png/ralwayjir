@extends('layouts.app')

@section('title', 'Detail Barang Masuk')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Barang Masuk</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap transaksi barang masuk.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    @php
        $total = $barangMasuk->jumlah * $barangMasuk->harga_beli;
    @endphp
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangMasuk->id_masuk }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Tanggal</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ \Carbon\Carbon::parse($barangMasuk->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $barangMasuk->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangMasuk->barang->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Supplier</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangMasuk->supplier->nama_supplier ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Ruangan Tujuan</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangMasuk->ruangan->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 600;">{{ $barangMasuk->jumlah }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Harga Beli</td>
            <td style="padding: 10px 0; color: #1a2a3a;">Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Total Nilai</td>
            <td style="padding: 10px 0; color: #0f2b4a; font-weight: 700;">Rp {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barangMasuk->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barangMasuk->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('barang-masuk.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection