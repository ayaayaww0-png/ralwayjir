@extends('layouts.app')

@section('title', 'Tambah Mutasi Barang')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">🔄 Tambah Mutasi Barang</h1>
        <p style="color: #6b7a8f; font-size: 14px;">Pindahkan barang antar ruangan - Khusus KIB B</p>
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

<form id="mutasiForm" action="{{ route('mutasi-barang.store') }}" method="POST" style="max-width: 600px;">
    @csrf

    {{-- Tanggal --}}
    <div style="margin-bottom: 16px;">
        <label for="tanggal" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Tanggal <span style="color: #dc2626;">*</span>
        </label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
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
                <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                </option>
            @endforeach
        </select>
        <small style="color: #6b7a8f; font-size: 12px;">Hanya menampilkan barang KIB B (Peralatan & Mesin)</small>
    </div>

    {{-- Ruangan Asal --}}
    <div style="margin-bottom: 16px;">
        <label for="id_ruangan_asal" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Ruangan Asal <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_ruangan_asal" name="id_ruangan_asal" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Ruangan Asal</option>
            {{-- Ruangan akan diisi oleh JavaScript --}}
        </select>
        <small id="stok-info" style="color: #6b7a8f; font-size: 12px;">Pilih barang terlebih dahulu</small>
    </div>

    {{-- Ruangan Tujuan --}}
    <div style="margin-bottom: 16px;">
        <label for="id_ruangan_tujuan" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Ruangan Tujuan <span style="color: #dc2626;">*</span>
        </label>
        <select id="id_ruangan_tujuan" name="id_ruangan_tujuan" required
                style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
            <option value="">Pilih Ruangan Tujuan</option>
            @foreach($ruangans as $ruangan)
                <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan_tujuan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                    {{ $ruangan->nama_ruangan }}
                </option>
            @endforeach
        </select>
        <small style="color: #6b7a8f; font-size: 12px;">Ruangan tujuan harus berbeda dari ruangan asal</small>
    </div>

    {{-- Jumlah --}}
    <div style="margin-bottom: 25px;">
        <label for="jumlah" style="display: block; font-weight: 600; color: #0f2b4a; margin-bottom: 6px; font-size: 14px;">
            Jumlah <span style="color: #dc2626;">*</span>
        </label>
        <input type="number" id="jumlah" name="jumlah" placeholder="Masukkan jumlah barang" value="{{ old('jumlah', 1) }}" required min="1"
               style="width: 100%; padding: 10px 14px; border: 2px solid #dce3ed; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #f8fafc;">
        <small id="jumlah-info" style="color: #6b7a8f; font-size: 12px;">Maksimal stok tersedia</small>
    </div>

    {{-- Tombol --}}
    <div style="display: flex; gap: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('mutasi-barang.index') }}" style="padding: 10px 28px; border: 2px solid #dce3ed; border-radius: 8px; text-decoration: none; color: #4a5568; font-weight: 600; transition: all 0.3s; background: white; text-align: center;">
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
        const ruanganAsalSelect = document.getElementById('id_ruangan_asal');
        const ruanganTujuanSelect = document.getElementById('id_ruangan_tujuan');
        const stokInfo = document.getElementById('stok-info');
        const jumlahInput = document.getElementById('jumlah');
        const jumlahInfo = document.getElementById('jumlah-info');

        // Simpan daftar semua ruangan untuk tujuan
        const allRuanganOptions = ruanganTujuanSelect.innerHTML;

        function updateRuanganAsal() {
            const barangId = barangSelect.value;
            if (!barangId) {
                ruanganAsalSelect.innerHTML = '<option value="">Pilih Barang Terlebih Dahulu</option>';
                stokInfo.textContent = 'Pilih barang terlebih dahulu';
                ruanganTujuanSelect.innerHTML = allRuanganOptions;
                return;
            }

            fetch(`/get-ruangan-with-stok?barang=${barangId}`)
                .then(response => response.json())
                .then(data => {
                    ruanganAsalSelect.innerHTML = '<option value="">Pilih Ruangan Asal</option>';
                    if (data.length === 0) {
                        ruanganAsalSelect.innerHTML = '<option value="">Tidak ada ruangan dengan stok</option>';
                        stokInfo.textContent = 'Tidak ada stok di ruangan manapun';
                        return;
                    }
                    data.forEach(ruangan => {
                        const option = document.createElement('option');
                        option.value = ruangan.id_ruangan;
                        option.textContent = `${ruangan.nama_ruangan} (Stok: ${ruangan.stok})`;
                        option.dataset.stok = ruangan.stok;
                        ruanganAsalSelect.appendChild(option);
                    });
                    stokInfo.textContent = 'Pilih ruangan asal';
                })
                .catch(error => {
                    console.error('Error:', error);
                    stokInfo.textContent = 'Gagal memuat data ruangan';
                });
        }

        function updateStok() {
            const selectedOption = ruanganAsalSelect.options[ruanganAsalSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.stok) {
                const stok = parseInt(selectedOption.dataset.stok);
                stokInfo.textContent = `Stok tersedia: ${stok}`;
                jumlahInput.max = stok;
                jumlahInfo.textContent = `Maksimal ${stok} (stok tersedia)`;
                if (parseInt(jumlahInput.value) > stok) {
                    jumlahInput.value = stok;
                }

                // Update ruangan tujuan (hilangkan ruangan asal)
                const asalId = selectedOption.value;
                const options = ruanganTujuanSelect.options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === asalId) {
                        options[i].disabled = true;
                        options[i].textContent = options[i].textContent + ' (Asal)';
                    } else {
                        options[i].disabled = false;
                        // Bersihkan label
                        if (options[i].textContent.includes(' (Asal)')) {
                            options[i].textContent = options[i].textContent.replace(' (Asal)', '');
                        }
                    }
                }
            } else {
                stokInfo.textContent = 'Pilih ruangan asal';
                jumlahInput.max = '';
                jumlahInfo.textContent = 'Maksimal stok tersedia';
            }
        }

        barangSelect.addEventListener('change', function() {
            updateRuanganAsal();
            ruanganAsalSelect.value = '';
            stokInfo.textContent = 'Pilih ruangan asal';
            jumlahInput.max = '';
            jumlahInfo.textContent = 'Maksimal stok tersedia';
            // Reset ruangan tujuan
            ruanganTujuanSelect.innerHTML = allRuanganOptions;
        });

        ruanganAsalSelect.addEventListener('change', updateStok);

        document.getElementById('mutasiForm').addEventListener('submit', function(e) {
            const maxStok = parseInt(jumlahInput.max) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;
            if (jumlah > maxStok) {
                e.preventDefault();
                alert(`Jumlah melebihi stok tersedia! Maksimal ${maxStok}`);
            }
        });

        // Jalankan pertama kali
        if (barangSelect.value) {
            updateRuanganAsal();
        }
    });
</script>
@endsection