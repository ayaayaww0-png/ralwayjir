@extends('layouts.app')

@section('title', 'Tambah Barang Habis Pakai')

@section('content')
<div style="margin-bottom: 20px;">
    <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">➕ Tambah Barang Habis Pakai</h1>
    <p style="color: #6b7a8f; font-size: 14px;">Isi form berikut untuk menambahkan barang habis pakai.</p>
</div>

@if($errors->any())
    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #991b1b;">
        <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('barang-habis-pakai.store') }}" method="POST" style="max-width: 500px;">
    @csrf

    <div style="margin-bottom: 16px;">
        <label style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Nama Barang <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Sisa Awal <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" name="sisa_awal" value="{{ old('sisa_awal', 0) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px;">
        <small style="color: #6b7a8f; font-size: 12px;">Sisa stok awal tahun {{ date('Y') }}</small>
    </div>

    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('barang-habis-pakai.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; background: white;">
            Kembali
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
            Simpan
        </button>
    </div>
</form>
@endsection