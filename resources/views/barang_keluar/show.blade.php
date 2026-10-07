@extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Barang Keluar</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap transaksi barang keluar.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangKeluar->id_keluar }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Tanggal</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $barangKeluar->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Kode Barang</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangKeluar->barang->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Ruangan Asal</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $barangKeluar->ruangan->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 600;">{{ $barangKeluar->jumlah }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jenis Keluar</td>
            <td style="padding: 10px 0;">
                @if($barangKeluar->jenis_keluar == 'rusak')
                    <span style="background: #fee2e2; color: #991b1b; padding: 3px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;">❌ RUSAK</span>
                @else
                    <span style="background: #fef3c7; color: #92400e; padding: 3px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;">⚠️ HILANG</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barangKeluar->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $barangKeluar->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('barang-keluar.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection