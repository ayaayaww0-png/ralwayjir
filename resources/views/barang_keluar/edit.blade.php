@extends('layouts.app')

@section('title', 'Edit Barang Keluar')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">✏️ Edit Barang Keluar</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Ubah data barang keluar.</p>
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

@if(session('error'))
    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; color: #991b1b;">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('barang-keluar.update', $barangKeluar->id_keluar) }}" method="POST" style="max-width: 600px;">
    @csrf
    @method('PUT')

    {{-- Tanggal --}}
    <div style="margin-bottom: 16px;">
        <label for="tanggal" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Tanggal <span style="color: #dc2626;">*</span>
        </label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($barangKeluar->tanggal)->format('Y-m-d')) }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    {{-- Barang --}}
    <div style="margin-bottom: 16px;">
        <label for="id_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Barang <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_barang" name="id_barang" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Barang</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->id_barang }}" {{ old('id_barang', $barangKeluar->id_barang) == $barang->id_barang ? 'selected' : '' }}>
                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok_total }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Ruangan Asal --}}
    <div style="margin-bottom: 16px;">
        <label for="id_ruangan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Ruangan Asal <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_ruangan" name="id_ruangan" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Ruangan</option>
            @foreach($ruangans as $ruangan)
                <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan', $barangKeluar->id_ruangan) == $ruangan->id_ruangan ? 'selected' : '' }}>
                    {{ $ruangan->nama_ruangan }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Jumlah --}}
    <div style="margin-bottom: 16px;">
        <label for="jumlah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Jumlah <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $barangKeluar->jumlah) }}" required min="1"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang yang keluar</small>
    </div>

    {{-- Jenis Keluar --}}
    <div style="margin-bottom: 25px;">
        <label for="jenis_keluar" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Jenis Keluar <span style="color: #dc2626;">*</span>
        </label>
        <select id="jenis_keluar" name="jenis_keluar" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Jenis</option>
            <option value="rusak" {{ old('jenis_keluar', $barangKeluar->jenis_keluar) == 'rusak' ? 'selected' : '' }}>❌ Rusak</option>
            <option value="hilang" {{ old('jenis_keluar', $barangKeluar->jenis_keluar) == 'hilang' ? 'selected' : '' }}>⚠️ Hilang</option>
        </select>
        <small style="color: #6b7a8f; font-size: 12px;">Pilih jenis keluar (rusak atau hilang)</small>
    </div>

    {{-- Tombol --}}
    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('barang-keluar.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
            Batal
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
            Simpan
        </button>
    </div>
</form>
@endsection