@extends('layouts.app')

@section('title', 'KIB B - Peralatan & Mesin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🖥️ KIB B (Peralatan & Mesin)</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Daftar peralatan dan mesin yang dimiliki sekolah.</p>
    </div>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('kib_b.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
            + Tambah Peralatan
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
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama Barang</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Stok</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">BAIK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">RUSAK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">HILANG</th>
                <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Harga</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $item)
                @php
                    $totalStok = $item->inventarisRuangan->sum('stok_baik') + 
                                 $item->inventarisRuangan->sum('stok_rusak') + 
                                 $item->inventarisRuangan->sum('stok_hilang');
                    $stokBaik = $item->inventarisRuangan->sum('stok_baik');
                    $stokRusak = $item->inventarisRuangan->sum('stok_rusak');
                    $stokHilang = $item->inventarisRuangan->sum('stok_hilang');
                    $ruangan = $item->inventarisRuangan->first()?->ruangan->nama_ruangan ?? '-';
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->kode_barang }}</td>
                    <td style="padding: 8px 12px;">{{ $item->nama_barang }}</td>
                    <td style="padding: 8px 12px;">{{ $ruangan }}</td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $totalStok }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #16a34a;">{{ $stokBaik }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #dc2626;">{{ $stokRusak }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #f59e0b;">{{ $stokHilang }}</td>
                    <td style="padding: 8px 12px; text-align: right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('kib_b.show', $item->id_barang) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('kib_b.edit', $item->id_barang) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                            <form action="{{ route('kib_b.destroy', $item->id_barang) }}" method="POST" style="display:inline;">
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
                    <td colspan="10" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada data peralatan.
                        @if(Auth::user()->role == 'admin')
                            <br><a href="{{ route('kib_b.create') }}" style="color: #1a4a7a;">Tambah peralatan sekarang</a>
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<br>
<div style="display: flex; gap: 10px;">
    <a href="{{ route('export.kib-b') }}" style="background: #16a34a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
        📊 Export Excel
    </a>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('kib_b.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            + Tambah Peralatan
        </a>
    @endif
</div>

<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Data: {{ $barangs->count() }}
</div>
@endsection