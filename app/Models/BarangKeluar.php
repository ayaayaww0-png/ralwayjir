<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluars';
    protected $primaryKey = 'id_keluar';
    protected $fillable = [
        'tanggal',
        'id_barang',
        'id_ruangan',
        'jumlah',
        'jenis_keluar'  // tambahkan ini
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}