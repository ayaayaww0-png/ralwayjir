<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
</head>
<body>
    <h1>Edit Kategori</h1>

    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nama Kategori:</label><br>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
        </div>
        <br>
        <button type="submit">Update</button>
        <a href="{{ route('kategori.index') }}">Batal</a>
    </form>
</body>
</html>