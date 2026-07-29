<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang Masuk</title>
</head>
<body>
    <h1>Tambah Barang Masuk</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang-masuk.index') }}">Kembali ke Daftar</a>
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

    <form action="{{ route('barang-masuk.store') }}" method="POST">
        @csrf
        
        <div>
            <label>Tanggal:</label><br>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>
        <br>
        
        <div>
            <label>Barang:</label><br>
            <select name="id_barang" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok_total }})
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Supplier:</label><br>
            <select name="id_supplier" required>
                <option value="">Pilih Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id_supplier }}" {{ old('id_supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                        {{ $supplier->nama_supplier }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Ruangan Tujuan:</label><br>
            <select name="id_ruangan" required>
                <option value="">Pilih Ruangan</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan') == $ruangan->id_ruangan ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Jumlah:</label><br>
            <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" required min="1">
        </div>
        <br>
        
        <button type="submit">Simpan</button>
        <a href="{{ route('barang-masuk.index') }}">Batal</a>
    </form>
</body>
</html>