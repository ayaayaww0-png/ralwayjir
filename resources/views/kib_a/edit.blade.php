@extends('layouts.app')

@section('title', 'Edit KIB A - Tanah')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">✏️ Edit Tanah</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Ubah data tanah.</p>
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

<form action="{{ route('kib_a.update', $barang->id_barang) }}" method="POST" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 16px;">
        <label for="kode_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Kode Barang <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required maxlength="50"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="nama_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Nama Tanah <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="register" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Register
        </label>
        <input type="text" id="register" name="register" value="{{ old('register', $barang->register ?? '') }}"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="luas" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Luas (M2) <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="luas" name="luas" value="{{ old('luas', $barang->luas ?? 0) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="tahun" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Tahun Perolehan <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $barang->tahun ?? date('Y')) }}" required min="1900" max="{{ date('Y') }}"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="lokasi" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Lokasi / Alamat <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $barang->lokasi ?? '') }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="status_tanah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Status Tanah
        </label>
        <select id="status_tanah" name="status_tanah" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Status</option>
            <option value="Hak Milik" {{ old('status_tanah', $barang->status_tanah ?? '') == 'Hak Milik' ? 'selected' : '' }}>Hak Milik</option>
            <option value="Hak Pakai" {{ old('status_tanah', $barang->status_tanah ?? '') == 'Hak Pakai' ? 'selected' : '' }}>Hak Pakai</option>
            <option value="Hak Guna Bangunan" {{ old('status_tanah', $barang->status_tanah ?? '') == 'Hak Guna Bangunan' ? 'selected' : '' }}>Hak Guna Bangunan</option>
            <option value="Hak Sewa" {{ old('status_tanah', $barang->status_tanah ?? '') == 'Hak Sewa' ? 'selected' : '' }}>Hak Sewa</option>
            <option value="Lainnya" {{ old('status_tanah', $barang->status_tanah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="kode_tanah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Kode Tanah
        </label>
        <input type="text" id="kode_tanah" name="kode_tanah" value="{{ old('kode_tanah', $barang->kode_tanah ?? '') }}"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="asal_usul" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Asal Usul
        </label>
        <select id="asal_usul" name="asal_usul" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Asal Usul</option>
            <option value="Hibah" {{ old('asal_usul', $barang->asal_usul ?? '') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
            <option value="Pembelian" {{ old('asal_usul', $barang->asal_usul ?? '') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
            <option value="Wakaf" {{ old('asal_usul', $barang->asal_usul ?? '') == 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
            <option value="Sumbangan" {{ old('asal_usul', $barang->asal_usul ?? '') == 'Sumbangan' ? 'selected' : '' }}>Sumbangan</option>
            <option value="Lainnya" {{ old('asal_usul', $barang->asal_usul ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>

    <div style="margin-bottom: 25px;">
        <label for="harga" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Harga (Rp) <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Masukkan nominal dalam Rupiah (tanpa titik atau koma)</small>
    </div>

    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('kib_a.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
            Batal
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
            Simpan
        </button>
    </div>
</form>
@endsection