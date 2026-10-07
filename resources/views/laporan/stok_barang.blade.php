@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📦 Laporan Stok Barang</h1>
            <p style="color: #6b7a8f; font-size: 14px;">Seluruh stok barang di sekolah.</p>
        </div>
        <div>
            <a href="{{ route('laporan.index') }}" style="padding: 8px 20px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; margin-right: 10px;">
                ← Kembali
            </a>
            <button type="submit" form="filter-form" name="cetak_pdf" value="1" style="padding: 8px 20px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                📄 Cetak PDF
            </button>
        </div>
    </div>

    {{-- Filter --}}
    <form id="filter-form" method="GET" action="{{ route('laporan.stok-barang') }}" style="background: #f8fafc; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Kategori:</label>
            <select name="kategori" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; background: white; margin-left: 5px;">
                <option value="">Semua</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Status:</label>
            <select name="status" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; background: white; margin-left: 5px;">
                <option value="">Semua</option>
                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>AMAN</option>
                <option value="menipis" {{ request('status') == 'menipis' ? 'selected' : '' }}>MENIPIS</option>
                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>HABIS</option>
            </select>
        </div>

        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Cari:</label>
            <input type="text" name="search" placeholder="Cari kode/nama..." value="{{ request('search') }}" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; margin-left: 5px; width: 180px;">
        </div>

        <button type="submit" style="padding: 6px 18px; background: #1a4a7a; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Filter</button>
        <a href="{{ route('laporan.stok-barang') }}" style="padding: 6px 18px; border: 2px solid #dce3ed; border-radius: 6px; text-decoration: none; color: #4a5568; font-weight: 600;">Reset</a>
    </form>

    {{-- Tabel --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Kode Barang</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama Barang</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Kategori</th>
                    <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #dce3ed;">Stok Total</th>
                    <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #dce3ed;">Min Stok</th>
                    <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #dce3ed;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $barang)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 10px 15px; font-weight: 500;">{{ $barang->kode_barang }}</td>
                        <td style="padding: 10px 15px;">{{ $barang->nama_barang }}</td>
                        <td style="padding: 10px 15px;">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td style="padding: 10px 15px; text-align: center;">{{ $barang->stok_total }}</td>
                        <td style="padding: 10px 15px; text-align: center;">{{ $barang->min_stok }}</td>
                        <td style="padding: 10px 15px; text-align: center;">
                            @if($barang->stok_total <= 0)
                                <span style="background: #fee2e2; color: #991b1b; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">HABIS</span>
                            @elseif($barang->stok_total <= $barang->min_stok)
                                <span style="background: #fef3c7; color: #92400e; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">MENIPIS</span>
                            @else
                                <span style="background: #dcfce7; color: #166534; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">AMAN</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #6b7a8f;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
        Total Barang: {{ $barangs->count() }}
    </div>
@endsection