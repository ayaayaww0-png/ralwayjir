@extends('layouts.app')

@section('title', 'Tambah KIB B - Peralatan & Mesin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">➕ Tambah Peralatan & Mesin</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Isi form berikut untuk menambahkan data peralatan baru.</p>
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

<form action="{{ route('kib_b.store') }}" method="POST" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 16px;">
        <label for="kode_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Kode Barang <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" id="kode_barang" name="kode_barang" placeholder="Contoh: PC-001" value="{{ old('kode_barang') }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="nama_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Nama Barang <span style="color: #dc2626;">*</span>
        </label>
        <input type="text" id="nama_barang" name="nama_barang" placeholder="Contoh: Komputer" value="{{ old('nama_barang') }}" required
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="merk" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Merk / Model
        </label>
        <input type="text" id="merk" name="merk" placeholder="Contoh: Asus" value="{{ old('merk') }}"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="no_seri" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            No. Seri
        </label>
        <input type="text" id="no_seri" name="no_seri" placeholder="Contoh: SN-001" value="{{ old('no_seri') }}"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
    </div>

    <div style="margin-bottom: 16px;">
        <label for="id_ruangan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Ruangan <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_ruangan" name="id_ruangan" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Ruangan</option>
            @foreach($ruangans as $ruangan)
                <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                    {{ $ruangan->nama_ruangan }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="stok_baik" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok BAIK <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="stok_baik" name="stok_baik" placeholder="0" value="{{ old('stok_baik', 0) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang kondisi BAIK</small>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="stok_rusak" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok RUSAK <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="stok_rusak" name="stok_rusak" placeholder="0" value="{{ old('stok_rusak', 0) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang kondisi RUSAK</small>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="stok_hilang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok HILANG <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="stok_hilang" name="stok_hilang" placeholder="0" value="{{ old('stok_hilang', 0) }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang kondisi HILANG</small>
    </div>

    <div style="margin-bottom: 25px;">
        <label for="harga" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Harga (Rp) <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="harga" name="harga" placeholder="Contoh: 10000000" value="{{ old('harga') }}" required min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Masukkan nominal dalam Rupiah (tanpa titik atau koma)</small>
    </div>

    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('kib_b.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
            Kembali
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
            Simpan
        </button>
    </div>
</form>
@endsection