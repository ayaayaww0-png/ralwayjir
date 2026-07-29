<!DOCTYPE html>
<html>
<head>
    <title>Edit Ruangan</title>
</head>
<body>
    <h1>Edit Ruangan</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('ruangan.index') }}">Kembali ke Daftar</a>
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

    <form action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
            <br><small>Contoh: Ruang Kelas 1A, Laboratorium, Perpustakaan, Kantor Guru</small>
        </div>
        <br>
        <button type="submit">Update</button>
        <a href="{{ route('ruangan.index') }}">Batal</a>
    </form>
</body>
</html>