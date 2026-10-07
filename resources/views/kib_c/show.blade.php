@extends('layouts.app')

@section('title', 'Detail KIB C - Gedung & Bangunan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Gedung & Bangunan</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap gedung.</p>
    </div>
</div>

@php
    $gedung = $barang->kibCGedung;
@endphp

<div style="max-width: 700px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
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
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Nama Gedung</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Register</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->register ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Kondisi Bangunan</td>
            <td style="padding: 8px 0; color: #1a2a3a;">
                @if($gedung->kondisi_bangunan == 'B')
                    <span style="background: #dcfce7; color: #166534; padding: 2px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">B (Baik)</span>
                @elseif($gedung->kondisi_bangunan == 'KB')
                    <span style="background: #fef3c7; color: #92400e; padding: 2px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">KB (Kurang Baik)</span>
                @elseif($gedung->kondisi_bangunan == 'RB')
                    <span style="background: #fee2e2; color: #991b1b; padding: 2px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">RB (Rusak Berat)</span>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Bertingkat</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->bertingkat ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Beton</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->beton ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Luas Lantai (M2)</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ number_format($gedung->luas_lantai ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Tahun Pembangunan</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->tahun_pembangunan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Lokasi / Alamat</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->lokasi_alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Tanggal Dokumen</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->tanggal_dokumen ? \Carbon\Carbon::parse($gedung->tanggal_dokumen)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Nomor Dokumen</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->nomor_dokumen ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Luas Tanah (M2)</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ number_format($gedung->luas_tanah ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Status Tanah</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->status_tanah ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Kode Tanah</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->kode_tanah ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Asal Usul</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $gedung->asal_usul ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Harga</td>
            <td style="padding: 8px 0; color: #0f2b4a; font-weight: 700;">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
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

<div style="margin-top: 20px;">
    <a href="{{ route('kib_c.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection