<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Tambah Barang Baru</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang.index') }}">Kembali ke Daftar</a>
    </div>

    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div>
            <label>Kode Barang:</label><br>
            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" required>
            <br><small>Contoh: BRG-001, LAP-001, MEJA-01</small>
        </div>
        <br>
        <div>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required>
            <br><small>Contoh: Laptop Asus, Meja Kayu, Buku Tulis</small>
        </div>
        <br>
        <div>
            <label>Kategori:</label><br>
            <select name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label>Minimal Stok:</label><br>
            <input type="number" name="min_stok" value="{{ old('min_stok', 5) }}" required min="0">
            <br><small>Batas minimal stok untuk peringatan</small>
        </div>
        <br>
        
        {{-- 🔥 HAPUS FIELD STOK AWAL --}}
        
        <div style="background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <strong>⚠️ Informasi:</strong> Stok awal akan <strong>0</strong>. Silakan tambahkan stok melalui menu <strong>Barang Masuk</strong>.
        </div>
        
        <button type="submit">Simpan</button>
        <a href="{{ route('barang.index') }}">Batal</a>
    </form>
</body>
</html>