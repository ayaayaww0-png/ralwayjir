@extends('layouts.app')

@section('title', 'Barang Habis Pakai')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📦 Barang Habis Pakai</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Daftar barang yang habis pakai.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <form method="GET" action="{{ route('barang-habis-pakai.index') }}" style="display: flex; gap: 5px; align-items: center;">
            <label style="font-weight: 600; font-size: 14px; color: #0f2b4a;">Tahun:</label>
            <select name="tahun" onchange="this.form.submit()" style="padding: 6px 12px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px;">
                @foreach($tahunList as $thn)
                    <option value="{{ $thn }}" {{ $thn == $tahun ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('barang-habis-pakai.create') }}" style="background: #0f2b4a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            + Tambah Barang
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: #dcfce7; border-left: 4px solid #22c55e; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #166534;">
        {{ session('success') }}
    </div>
@endif

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr style="background: #f1f4f9;">
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                <th style="padding: 10px 12px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama Barang</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Sisa Awal</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Masuk</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Keluar</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Sisa Akhir</th>
                <th style="padding: 10px 12px; text-align: center; border-bottom: 2px solid #dce3ed;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $item)
                @php
                    $totalM = $item->jan_m + $item->feb_m + $item->mar_m + $item->apr_m + $item->mei_m + $item->jun_m + $item->jul_m + $item->agu_m + $item->sep_m + $item->okt_m + $item->nov_m + $item->des_m;
                    $totalK = $item->jan_k + $item->feb_k + $item->mar_k + $item->apr_k + $item->mei_k + $item->jun_k + $item->jul_k + $item->agu_k + $item->sep_k + $item->okt_k + $item->nov_k + $item->des_k;
                    $sisaAkhir = $item->des_sisa;
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 8px 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 8px 12px; font-weight: 500;">{{ $item->nama_barang }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ $item->sisa_awal }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ $totalM }}</td>
                    <td style="padding: 8px 12px; text-align: center;">{{ $totalK }}</td>
                    <td style="padding: 8px 12px; text-align: center; font-weight: 600; color: #1a4a7a;">{{ $sisaAkhir }}</td>
                    <td style="padding: 8px 12px; text-align: center;">
                        <a href="{{ route('barang-habis-pakai.show', $item->id) }}" style="color: #1a4a7a; text-decoration: none; margin-right: 8px;">Detail</a>
                        <a href="{{ route('barang-habis-pakai.edit', $item->id) }}" style="color: #92400e; text-decoration: none; margin-right: 8px;">Edit</a>
                        <form action="{{ route('barang-habis-pakai.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus data ini?')" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 14px; text-decoration: underline;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: #6b7a8f;">
                        📭 Belum ada data barang habis pakai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection