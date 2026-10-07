@extends('layouts.app')

@section('title', 'Daftar Inventaris Ruangan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📋 Daftar Inventaris Ruangan</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Kelola stok barang per ruangan - Khusus KIB B.</p>
    </div>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('inventaris.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
            + Tambah Inventaris
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
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">ID</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Barang</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">BAIK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">RUSAK</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">HILANG</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Total</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $item)
                @php
                    $totalStok = $item->stok_baik + $item->stok_rusak + $item->stok_hilang;
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $item->id_inventaris }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td style="padding: 8px 12px;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #16a34a; font-weight: 600;">{{ $item->stok_baik }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #dc2626; font-weight: 600;">{{ $item->stok_rusak }}</td>
                    <td style="padding: 8px 12px; text-align: center; color: #f59e0b; font-weight: 600;">{{ $item->stok_hilang }}</td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $totalStok }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('inventaris.show', $item->id_inventaris) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('inventaris.edit', $item->id_inventaris) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                            <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus inventaris ini?')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada inventaris ruangan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Inventaris: {{ $inventaris->count() }}
</div>
@endsection