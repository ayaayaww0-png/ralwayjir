@extends('layouts.app')

@section('title', 'Detail Mutasi Barang')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Mutasi Barang</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap mutasi barang.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $mutasiBarang->id_mutasi }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Tanggal</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ \Carbon\Carbon::parse($mutasiBarang->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $mutasiBarang->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $mutasiBarang->barang->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Ruangan Asal</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $mutasiBarang->ruanganAsal->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Ruangan Tujuan</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $mutasiBarang->ruanganTujuan->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 600;">{{ $mutasiBarang->jumlah }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $mutasiBarang->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $mutasiBarang->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('mutasi-barang.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection