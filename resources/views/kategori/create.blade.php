<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
</head>
<body>
    <h1>Tambah Kategori Baru</h1>

    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama Kategori:</label><br>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
        </div>
        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('kategori.index') }}">Batal</a>
    </form>
</body>
</html>