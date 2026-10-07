@extends('layouts.app')

@section('title', 'Detail Barang Habis Pakai')

@section('content')
<div style="margin-bottom: 20px;">
    <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Barang Habis Pakai</h1>
    <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap dan input bulanan.</p>
</div>

@if(session('success'))
    <div style="background: #dcfce7; border-left: 4px solid #22c55e; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #166534;">
        {{ session('success') }}
    </div>
@endif

<div style="background: #f8fafc; border-radius: 12px; padding: 20px 25px; margin-bottom: 25px;">
    <table style="width: 100%; max-width: 500px; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a; width: 35%;">Nama Barang</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 500;">{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Tahun</td>
            <td style="padding: 8px 0; color: #1a2a3a;">{{ $barang->tahun }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: 600; color: #0f2b4a;">Sisa Awal</td>
            <td style="padding: 8px 0; color: #1a2a3a; font-weight: 600;">{{ $barang->sisa_awal }}</td>
        </tr>
    </table>
</div>

<div style="overflow-x: auto; margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr style="background: #f1f4f9;">
                <th style="padding: 8px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Bulan</th>
                <th style="padding: 8px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">M (Masuk)</th>
                <th style="padding: 8px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Jml</th>
                <th style="padding: 8px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">K (Keluar)</th>
                <th style="padding: 8px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Sisa</th>
                <th style="padding: 8px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $months = [
                    'jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret',
                    'apr' => 'April', 'mei' => 'Mei', 'jun' => 'Juni',
                    'jul' => 'Juli', 'agu' => 'Agustus', 'sep' => 'September',
                    'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'
                ];
            @endphp
            @foreach($months as $key => $label)
                @php
                    $m = $barang->{$key . '_m'};
                    $k = $barang->{$key . '_k'};
                    $jml = $barang->{$key . '_jml'};
                    $sisa = $barang->{$key . '_sisa'};
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0; {{ $key == 'des' ? 'font-weight: 600;' : '' }}">
                    <td style="padding: 6px 12px;">{{ $label }}</td>
                    <td style="padding: 6px 12px; text-align: center; color: #16a34a;">{{ $m }}</td>
                    <td style="padding: 6px 12px; text-align: center;">{{ $jml }}</td>
                    <td style="padding: 6px 12px; text-align: center; color: #dc2626;">{{ $k }}</td>
                    <td style="padding: 6px 12px; text-align: center; font-weight: {{ $key == 'des' ? '700' : '400' }}; color: {{ $key == 'des' ? '#1a4a7a' : '#1a2a3a' }};">
                        {{ $sisa }}
                    </td>
                    <td style="padding: 6px 12px; text-align: center;">
                        <form method="POST" action="{{ route('barang-habis-pakai.updateBulan', $barang->id) }}" style="display: flex; gap: 4px; justify-content: center; align-items: center; flex-wrap: wrap;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="bulan" value="{{ $key }}">
                            <input type="number" name="m" value="{{ $m }}" style="width: 50px; padding: 4px 6px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 12px;" placeholder="M">
                            <input type="number" name="k" value="{{ $k }}" style="width: 50px; padding: 4px 6px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 12px;" placeholder="K">
                            <button type="submit" style="padding: 4px 12px; background: #0f2b4a; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer;">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('barang-habis-pakai.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection