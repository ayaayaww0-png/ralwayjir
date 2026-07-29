<!DOCTYPE html>
<html>
<head>
    <title>Tambah Ruangan</title>
</head>
<body>
    <h1>Tambah Ruangan Baru</h1>

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

    <form action="{{ route('ruangan.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}" required>
            <br><small>Contoh: Ruang Kelas 1A, Laboratorium, Perpustakaan, Kantor Guru</small>
        </div>
        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('ruangan.index') }}">Batal</a>
    </form>
</body>
</html>