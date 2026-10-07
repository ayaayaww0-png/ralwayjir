@extends('layouts.app')

@section('title', 'Daftar Mutasi Barang')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🔄 Daftar Mutasi Barang</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Riwayat pemindahan barang antar ruangan.</p>
    </div>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('mutasi-barang.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
            + Tambah Mutasi Barang
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
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Dari Ruangan</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Ke Ruangan</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Jumlah</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutasiBarangs as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $item->id_mutasi }}</td>
                    <td style="padding: 8px 12px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td style="padding: 8px 12px;">
                        <span style="background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 12px; font-size: 12px;">
                            {{ $item->ruanganAsal->nama_ruangan ?? '-' }}
                        </span>
                    </td>
                    <td style="padding: 8px 12px;">
                        <span style="background: #dbeafe; color: #1e40af; padding: 2px 10px; border-radius: 12px; font-size: 12px;">
                            {{ $item->ruanganTujuan->nama_ruangan ?? '-' }}
                        </span>
                    </td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600;">{{ $item->jumlah }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('mutasi-barang.show', $item->id_mutasi) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('mutasi-barang.edit', $item->id_mutasi) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                            <form action="{{ route('mutasi-barang.destroy', $item->id_mutasi) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus mutasi ini? Stok akan dikembalikan.')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada transaksi mutasi barang.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
    Total Mutasi: {{ $mutasiBarangs->count() }}
</div>
@endsection