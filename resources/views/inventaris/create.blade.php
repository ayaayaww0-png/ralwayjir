<!DOCTYPE html>
<html>
<head>
    <title>Tambah Inventaris Ruangan</title>
</head>
<body>
    <h1>Tambah Inventaris Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('inventaris.index') }}">Kembali ke Daftar</a>
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

    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf
        
        <div>
            <label>Barang:</label><br>
            <select name="id_barang" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Ruangan:</label><br>
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
            <label>Stok:</label><br>
            <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0">
        </div>
        <br>
        
        <div>
            <label>Kondisi:</label><br>
            <select name="kondisi" required>
                <option value="">Pilih Kondisi</option>
                <option value="BAIK" {{ old('kondisi') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
                <option value="RUSAK" {{ old('kondisi') == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
                <option value="HILANG" {{ old('kondisi') == 'HILANG' ? 'selected' : '' }}>HILANG</option>
            </select>
        </div>
        <br>
        
        <button type="submit">Simpan</button>
        <a href="{{ route('inventaris.index') }}">Batal</a>
    </form>
</body>
</html>