@extends('layouts.app')

@section('title', 'Detail Supplier')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">📄 Detail Supplier</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Informasi lengkap supplier.</p>
    </div>
</div>

<div style="max-width: 600px; background: #f8fafc; border-radius: 12px; padding: 25px 30px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a; width: 40%;">ID</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $supplier->id_supplier }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Nama Supplier</td>
            <td style="padding: 10px 0; color: #1a2a3a; font-weight: 500;">{{ $supplier->nama_supplier }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Dibuat</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $supplier->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Diupdate</td>
            <td style="padding: 10px 0; color: #6b7a8f;">{{ $supplier->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah Barang Masuk</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $supplier->barangMasuk->count() }} transaksi</td>
        </tr>
        {{-- HAPUS BAGIAN INI KARENA SUDAH TIDAK ADA --}}
        {{--
        <tr>
            <td style="padding: 10px 0; font-weight: 600; color: #0f2b4a;">Jumlah Inventaris</td>
            <td style="padding: 10px 0; color: #1a2a3a;">{{ $supplier->inventarisRuangan->count() }} item</td>
        </tr>
        --}}
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('supplier.index') }}" style="padding: 10px 24px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; display: inline-block;">
        ← Kembali
    </a>
</div>
@endsection