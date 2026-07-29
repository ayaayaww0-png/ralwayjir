<!DOCTYPE html>
<html>
<head>
    <title>Edit Mutasi Barang</title>
</head>
<body>
    <h1>Edit Mutasi Barang</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('mutasi-barang.index') }}">Kembali ke Daftar</a>
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

    <form action="{{ route('mutasi-barang.update', $mutasiBarang->id_mutasi) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label>Tanggal:</label><br>
            <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($mutasiBarang->tanggal)->format('Y-m-d')) }}" required>
        </div>
        <br>
        
        <div>
            <label>Barang:</label><br>
            <select name="id_barang" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" {{ old('id_barang', $mutasiBarang->id_barang) == $barang->id_barang ? 'selected' : '' }}>
                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Total: {{ $barang->stok_total }})
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Ruangan Asal:</label><br>
            <select name="id_ruangan_asal" required>
                <option value="">Pilih Ruangan Asal</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan_asal', $mutasiBarang->id_ruangan_asal) == $ruangan->id_ruangan ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Ruangan Tujuan:</label><br>
            <select name="id_ruangan_tujuan" required>
                <option value="">Pilih Ruangan Tujuan</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan_tujuan', $mutasiBarang->id_ruangan_tujuan) == $ruangan->id_ruangan ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Jumlah:</label><br>
            <input type="number" name="jumlah" value="{{ old('jumlah', $mutasiBarang->jumlah) }}" required min="1">
        </div>
        <br>
        
        <button type="submit">Update</button>
        <a href="{{ route('mutasi-barang.index') }}">Batal</a>
    </form>
</body>
</html>