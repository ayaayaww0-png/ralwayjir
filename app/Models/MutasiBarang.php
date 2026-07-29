<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $table = 'mutasi_barangs';
    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'tanggal',
        'id_barang',
        'id_ruangan_asal',
        'id_ruangan_tujuan',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruanganAsal()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_asal', 'id_ruangan');
    }

    public function ruanganTujuan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_tujuan', 'id_ruangan');
    }
}