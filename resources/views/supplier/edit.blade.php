<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
</head>
<body>
    <h1>Edit Supplier</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('supplier.index') }}">Kembali ke Daftar</a>
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

    <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nama Supplier:</label><br>
            <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
            <br><small>Contoh: Toko ATK, CV Maju Jaya, PT Sentosa</small>
        </div>
        <br>
        <button type="submit">Update</button>
        <a href="{{ route('supplier.index') }}">Batal</a>
    </form>
</body>
</html>