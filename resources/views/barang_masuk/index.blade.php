@extends('layouts.app')

@section('title', 'Daftar Barang Masuk')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📥 Daftar Barang Masuk</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Riwayat barang masuk dari supplier.</p>
    </div>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('barang-masuk.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
            + Tambah Barang Masuk
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
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Tanggal</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Barang</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Supplier</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Jumlah</th>
                <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Harga Beli</th>
                <th style="padding: 10px 12px; text-align: right; border-bottom: 2px solid #dce3ed;">Total</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangMasuks as $item)
                @php
                    $total = $item->jumlah * $item->harga_beli;
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $item->id_masuk }}</td>
                    <td style="padding: 8px 12px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td style="padding: 8px 12px;">{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td style="padding: 8px 12px;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $item->jumlah }}</td>
                    <td style="padding: 8px 12px; text-align: right;">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td style="padding: 8px 12px; text-align: right; font-weight: 600; color: #0f2b4a;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('barang-masuk.show', $item->id_masuk) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('barang-masuk.edit', $item->id_masuk) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                            <form action="{{ route('barang-masuk.destroy', $item->id_masuk) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada transaksi barang masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Transaksi: {{ $barangMasuks->count() }}
</div>
@endsection