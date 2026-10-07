@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">➕ Tambah Supplier</h1>
            <p style="color: #6b7a8f; font-size: 14px;">Isi form berikut untuk menambahkan supplier baru.</p>
        </div>
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

    <form action="{{ route('supplier.store') }}" method="POST" style="max-width: 600px;">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="nama_supplier" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Nama Supplier <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" id="nama_supplier" name="nama_supplier" placeholder="Masukkan nama supplier" value="{{ old('nama_supplier') }}" required
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Tanggal
            </label>
            <input type="text" value="{{ date('d F Y') }}" disabled
                   style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: #f1f4f9; color: #6b7a8f;">
            <small style="color: #6b7a8f; font-size: 12px;">Tanggal pembuatan akan otomatis tercatat</small>
        </div>

        <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
            <a href="{{ route('supplier.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
                Batal
            </a>
            <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
                Simpan
            </button>
        </div>
    </form>
@endsection