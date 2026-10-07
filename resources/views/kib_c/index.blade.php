@extends('layouts.app')

@section('title', 'KIB C - Gedung & Bangunan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🏗️ KIB C (Gedung & Bangunan)</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Daftar gedung dan bangunan yang dimiliki sekolah.</p>
    </div>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('kib_c.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
            + Tambah Gedung
        </a>
    @endif
</div>

@if(session('success'))
    <div style="background: #dcfce7; border-left: 4px solid #22c55e; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #166534;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #991b1b;">
        {{ session('error') }}
    </div>
@endif

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: #f1f4f9;">
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Kode</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama Gedung</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Register</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Luas (M2)</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Tahun</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Lokasi</th>
                <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Harga</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $item)
                @php
                    $gedung = $item->kibCGedung;
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->kode_barang }}</td>
                    <td style="padding: 8px 12px;">{{ $item->nama_barang }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ $gedung->register ?? '-' }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ number_format($gedung->luas_lantai ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ $gedung->tahun_pembangunan ?? '-' }}</td>
                    <td style="padding: 8px 12px;">{{ $gedung->lokasi_alamat ?? '-' }}</td>
                    <td style="padding: 8px 12px; text-align: right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('kib_c.show', $item->id_barang) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('kib_c.edit', $item->id_barang) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                            <form action="{{ route('kib_c.destroy', $item->id_barang) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus data ini?')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada data gedung.
                        @if(Auth::user()->role == 'admin')
                            <br><a href="{{ route('kib_c.create') }}" style="color: #1a4a7a;">Tambah gedung sekarang</a>
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<br>
<div style="display: flex; gap: 10px;">
    <a href="{{ route('export.kib-c') }}" style="background: #16a34a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
        📊 Export Excel
    </a>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('kib_c.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            + Tambah Gedung
        </a>
    @endif
</div>


<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Data: {{ $barangs->count() }}
</div>
@endsection