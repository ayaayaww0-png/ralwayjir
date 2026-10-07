<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarisRuangan extends Model
{
    protected $table = 'inventaris_ruangans';
    protected $primaryKey = 'id_inventaris';
    protected $fillable = [
        'id_barang',
        'id_ruangan',
        'stok_baik',
        'stok_rusak',
        'stok_hilang'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    // HAPUS METHOD supplier() KARENA SUDAH TIDAK DIPAKAI
    // public function supplier() { ... }

    public function getStokTotalAttribute()
    {
        return $this->stok_baik + $this->stok_rusak + $this->stok_hilang;
    }
}