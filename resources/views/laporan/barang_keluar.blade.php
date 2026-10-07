@extends('layouts.app')

@section('title', 'Laporan Barang Keluar')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📤 Laporan Barang Keluar</h1>
            <p style="color: #6b7a8f; font-size: 14px;">Riwayat barang keluar (rusak/hilang).</p>
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
    <form id="filter-form" method="GET" action="{{ route('laporan.barang-keluar') }}" style="background: #f8fafc; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Dari Tanggal:</label>
            <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; margin-left: 5px;">
        </div>

        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Sampai Tanggal:</label>
            <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; margin-left: 5px;">
        </div>

        <div>
            <label style="font-weight: 600; font-size: 13px; color: #0f2b4a;">Ruangan:</label>
            <select name="ruangan" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 6px; font-size: 13px; background: white; margin-left: 5px;">
                <option value="">Semua</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id_ruangan }}" {{ request('ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" style="padding: 6px 18px; background: #1a4a7a; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Filter</button>
        <a href="{{ route('laporan.barang-keluar') }}" style="padding: 6px 18px; border: 2px solid #dce3ed; border-radius: 6px; text-decoration: none; color: #4a5568; font-weight: 600;">Reset</a>
    </form>

    {{-- Tabel --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Tanggal</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Barang</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Ruangan</th>
                    <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #dce3ed;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangKeluars as $index => $item)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 10px 15px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td style="padding: 10px 15px; font-weight: 500;">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td style="padding: 10px 15px;">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td style="padding: 10px 15px; text-align: center;">
                            <span style="background: #fee2e2; color: #991b1b; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                -{{ $item->jumlah }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #6b7a8f;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
        Total Transaksi Keluar: {{ $barangKeluars->count() }}
    </div>
@endsection