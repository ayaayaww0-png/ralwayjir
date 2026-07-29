<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang</h1>

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

    <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label>Kode Barang:</label><br>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
            <br><small>Contoh: BRG-001, LAP-001, MEJA-01</small>
        </div>
        <br>
        
        <div>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            <br><small>Contoh: Laptop Asus, Meja Kayu, Buku Tulis</small>
        </div>
        <br>
        
        <div>
            <label>Kategori:</label><br>
            <select name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $barang->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        
        <div>
            <label>Minimal Stok:</label><br>
            <input type="number" name="min_stok" value="{{ old('min_stok', $barang->min_stok) }}" required min="0">
            <br><small>Batas minimal stok untuk peringatan</small>
        </div>
        <br>
        
        <button type="submit">Update</button>
        <a href="{{ route('barang.index') }}">Batal</a>
    </form>
</body>
</html>