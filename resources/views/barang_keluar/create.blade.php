<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang Keluar</title>
</head>
<body>
    <h1>Tambah Barang Keluar</h1>

    <div style="margin-bottom: 10px;">
        <a href="{{ route('barang-keluar.index') }}">Kembali ke Daftar</a>
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

    <form action="{{ route('barang-keluar.store') }}" method="POST">
        @csrf
        
        <div>
            <label>Tanggal:</label><br>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>
        <br>
        
        <div>
            <label>Barang:</label><br>
            <select name="id_barang" id="barang_select" required onchange="updateStokInfo()">
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Total: {{ $barang->stok_total }})
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>
            <label>Ruangan Asal:</label><br>
            <select name="id_ruangan" id="ruangan_select" required>
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
            <input type="number" name="jumlah" id="jumlah_input" value="{{ old('jumlah', 1) }}" required min="1">
        </div>
        <br>
        
        <button type="submit">Simpan</button>
        <a href="{{ route('barang-keluar.index') }}">Batal</a>
    </form>

    <script>
        function updateStokInfo() {
            // Ini hanya untuk tampilan, validasi tetap di server
            var barangId = document.getElementById('barang_select').value;
            var ruanganId = document.getElementById('ruangan_select').value;
            
            if (barangId && ruanganId) {
                // Fetch stok dari server
                fetch('/get-stok-ruangan?barang=' + barangId + '&ruangan=' + ruanganId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('stok_info').innerHTML = 'Stok tersedia: ' + data.stok;
                    })
                    .catch(() => {
                        document.getElementById('stok_info').innerHTML = 'Stok tersedia: (gagal load)';
                    });
            } else {
                document.getElementById('stok_info').innerHTML = 'Stok tersedia: -';
            }
        }

        // Event listener untuk perubahan ruangan
        document.getElementById('ruangan_select').addEventListener('change', updateStokInfo);
        document.getElementById('barang_select').addEventListener('change', updateStokInfo);
    </script>
</body>
</html>