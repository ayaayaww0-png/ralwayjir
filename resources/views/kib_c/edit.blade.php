@extends('layouts.app')

@section('title', 'Edit KIB C - Gedung & Bangunan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">✏️ Edit Gedung & Bangunan</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Ubah data gedung.</p>
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

<form action="{{ route('kib_c.update', $barang->id_barang) }}" method="POST" style="max-width: 700px;">
    @csrf
    @method('PUT')

    {{-- Data Barang --}}
    <div style="background: #f1f4f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <h4 style="color: #0f2b4a; margin-bottom: 15px;">📋 Data Barang</h4>

        <div style="margin-bottom: 16px;">
            <label for="kode_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Kode Barang <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="nama_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Nama Gedung / Bangunan <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="register" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Register
            </label>
            <input type="text" id="register" name="register" value="{{ old('register', $barang->kibCGedung->register ?? '') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="harga" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Harga (Rp) <span style="color: #dc2626;">*</span>
            </label>
            <input type="number" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <small style="color: #6b7a8f; font-size: 12px;">Masukkan nominal dalam Rupiah (tanpa titik atau koma)</small>
        </div>
    </div>

    {{-- Data KIB C --}}
    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <h4 style="color: #0f2b4a; margin-bottom: 15px;">🏗️ Data Gedung</h4>

        <div style="margin-bottom: 16px;">
            <label for="kondisi_bangunan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Kondisi Bangunan
            </label>
            <select id="kondisi_bangunan" name="kondisi_bangunan" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
                <option value="">Pilih Kondisi</option>
                <option value="B" {{ old('kondisi_bangunan', $barang->kibCGedung->kondisi_bangunan ?? '') == 'B' ? 'selected' : '' }}>B (Baik)</option>
                <option value="KB" {{ old('kondisi_bangunan', $barang->kibCGedung->kondisi_bangunan ?? '') == 'KB' ? 'selected' : '' }}>KB (Kurang Baik)</option>
                <option value="RB" {{ old('kondisi_bangunan', $barang->kibCGedung->kondisi_bangunan ?? '') == 'RB' ? 'selected' : '' }}>RB (Rusak Berat)</option>
            </select>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="bertingkat" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Bertingkat
            </label>
            <select id="bertingkat" name="bertingkat" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
                <option value="">Pilih</option>
                <option value="Ya" {{ old('bertingkat', $barang->kibCGedung->bertingkat ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                <option value="Tidak" {{ old('bertingkat', $barang->kibCGedung->bertingkat ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="beton" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Beton
            </label>
            <select id="beton" name="beton" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
                <option value="">Pilih</option>
                <option value="Ya" {{ old('beton', $barang->kibCGedung->beton ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                <option value="Tidak" {{ old('beton', $barang->kibCGedung->beton ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="luas_lantai" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Luas Lantai (M2)
            </label>
            <input type="number" id="luas_lantai" name="luas_lantai" value="{{ old('luas_lantai', $barang->kibCGedung->luas_lantai ?? '') }}" min="0"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="tahun_pembangunan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Tahun Pembangunan
            </label>
            <input type="number" id="tahun_pembangunan" name="tahun_pembangunan" value="{{ old('tahun_pembangunan', $barang->kibCGedung->tahun_pembangunan ?? '') }}" min="1900" max="{{ date('Y') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="lokasi_alamat" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Lokasi / Alamat
            </label>
            <input type="text" id="lokasi_alamat" name="lokasi_alamat" value="{{ old('lokasi_alamat', $barang->kibCGedung->lokasi_alamat ?? '') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="tanggal_dokumen" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Tanggal Dokumen
            </label>
            <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $barang->kibCGedung->tanggal_dokumen ?? '') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="nomor_dokumen" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Nomor Dokumen
            </label>
            <input type="text" id="nomor_dokumen" name="nomor_dokumen" value="{{ old('nomor_dokumen', $barang->kibCGedung->nomor_dokumen ?? '') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="luas_tanah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Luas Tanah (M2)
            </label>
            <input type="number" id="luas_tanah" name="luas_tanah" value="{{ old('luas_tanah', $barang->kibCGedung->luas_tanah ?? '') }}" min="0"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="status_tanah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Status Tanah
            </label>
            <select id="status_tanah" name="status_tanah" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
                <option value="">Pilih Status</option>
                <option value="Hak Milik" {{ old('status_tanah', $barang->kibCGedung->status_tanah ?? '') == 'Hak Milik' ? 'selected' : '' }}>Hak Milik</option>
                <option value="Hak Pakai" {{ old('status_tanah', $barang->kibCGedung->status_tanah ?? '') == 'Hak Pakai' ? 'selected' : '' }}>Hak Pakai</option>
                <option value="Hak Guna Bangunan" {{ old('status_tanah', $barang->kibCGedung->status_tanah ?? '') == 'Hak Guna Bangunan' ? 'selected' : '' }}>Hak Guna Bangunan</option>
                <option value="Hak Sewa" {{ old('status_tanah', $barang->kibCGedung->status_tanah ?? '') == 'Hak Sewa' ? 'selected' : '' }}>Hak Sewa</option>
                <option value="Lainnya" {{ old('status_tanah', $barang->kibCGedung->status_tanah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="kode_tanah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Kode Tanah
            </label>
            <input type="text" id="kode_tanah" name="kode_tanah" value="{{ old('kode_tanah', $barang->kibCGedung->kode_tanah ?? '') }}"
                   style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="asal_usul" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
                Asal Usul
            </label>
            <select id="asal_usul" name="asal_usul" style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
                <option value="">Pilih Asal Usul</option>
                <option value="Hibah" {{ old('asal_usul', $barang->kibCGedung->asal_usul ?? '') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                <option value="Pembelian" {{ old('asal_usul', $barang->kibCGedung->asal_usul ?? '') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                <option value="Wakaf" {{ old('asal_usul', $barang->kibCGedung->asal_usul ?? '') == 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                <option value="Sumbangan" {{ old('asal_usul', $barang->kibCGedung->asal_usul ?? '') == 'Sumbangan' ? 'selected' : '' }}>Sumbangan</option>
                <option value="Lainnya" {{ old('asal_usul', $barang->kibCGedung->asal_usul ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
    </div>

    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('kib_c.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
            Batal
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
            Simpan
        </button>
    </div>
</form>
@endsection