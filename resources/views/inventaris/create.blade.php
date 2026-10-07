@extends('layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">➕ Tambah Inventaris</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Isi form berikut untuk menambahkan inventaris baru.</p>
        <p style="color: #f59e0b; font-size: 13px;">⚠️ Hanya untuk barang KIB B (Peralatan & Mesin)</p>
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

<form action="{{ route('inventaris.store') }}" method="POST" style="max-width: 600px;">
    @csrf

    {{-- Barang --}}
    <div style="margin-bottom: 16px;">
        <label for="id_barang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Barang <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_barang" name="id_barang" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Barang</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                </option>
            @endforeach
        </select>
        <small style="color: #6b7a8f; font-size: 12px;">Hanya menampilkan barang KIB B (Peralatan & Mesin)</small>
    </div>

    {{-- Ruangan --}}
    <div style="margin-bottom: 16px;">
        <label for="id_ruangan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Ruangan <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_ruangan" name="id_ruangan" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Ruangan</option>
        </select>
        <small id="stok-info" style="color: #6b7a8f; font-size: 12px;">Pilih barang terlebih dahulu untuk melihat ruangan yang tersedia</small>
    </div>

    {{-- Stok Baik --}}
    <div style="margin-bottom: 16px;">
        <label for="stok_baik" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok BAIK
        </label>
        <input type="number" id="stok_baik" name="stok_baik" placeholder="0" value="{{ old('stok_baik', 0) }}" min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang dengan kondisi BAIK</small>
    </div>

    {{-- Stok Rusak --}}
    <div style="margin-bottom: 16px;">
        <label for="stok_rusak" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok RUSAK
        </label>
        <input type="number" id="stok_rusak" name="stok_rusak" placeholder="0" value="{{ old('stok_rusak', 0) }}" min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang dengan kondisi RUSAK</small>
    </div>

    {{-- Stok Hilang --}}
    <div style="margin-bottom: 25px;">
        <label for="stok_hilang" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Stok HILANG
        </label>
        <input type="number" id="stok_hilang" name="stok_hilang" placeholder="0" value="{{ old('stok_hilang', 0) }}" min="0"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small style="color: #6b7a8f; font-size: 12px;">Jumlah barang dengan kondisi HILANG</small>
    </div>

    {{-- Tombol --}}
    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('inventaris.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
            Kembali
        </a>
        <button type="submit" style="padding: 10px 32px; background: #0f2b4a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
            Simpan
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('id_barang');
        const ruanganSelect = document.getElementById('id_ruangan');
        const stokInfo = document.getElementById('stok-info');

        function updateRuangan() {
            const barangId = barangSelect.value;
            if (!barangId) {
                ruanganSelect.innerHTML = '<option value="">Pilih Barang Terlebih Dahulu</option>';
                stokInfo.textContent = 'Pilih barang terlebih dahulu';
                return;
            }

            // Tampilkan loading
            ruanganSelect.innerHTML = '<option value="">Memuat ruangan...</option>';

            fetch(`/get-ruangan-with-stok?barang=${barangId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data ruangan:', data);
                    ruanganSelect.innerHTML = '<option value="">Pilih Ruangan</option>';
                    if (data.length === 0) {
                        ruanganSelect.innerHTML = '<option value="">Tidak ada ruangan dengan stok</option>';
                        stokInfo.textContent = 'Tidak ada ruangan dengan stok untuk barang ini';
                        return;
                    }
                    data.forEach(ruangan => {
                        const option = document.createElement('option');
                        option.value = ruangan.id_ruangan;
                        option.textContent = `${ruangan.nama_ruangan} (Stok: ${ruangan.stok})`;
                        option.dataset.stok = ruangan.stok;
                        ruanganSelect.appendChild(option);
                    });
                    stokInfo.textContent = 'Pilih ruangan untuk menambah stok';
                })
                .catch(error => {
                    console.error('Error:', error);
                    ruanganSelect.innerHTML = '<option value="">Gagal memuat ruangan</option>';
                    stokInfo.textContent = 'Gagal memuat data ruangan';
                });
        }

        barangSelect.addEventListener('change', updateRuangan);

        // Jalankan pertama kali kalau barang sudah terpilih (misal old value)
        if (barangSelect.value) {
            updateRuangan();
        }
    });
</script>
@endsection