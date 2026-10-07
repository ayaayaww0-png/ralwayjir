<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KIBCGedung extends Model
{
    protected $table = 'kib_c_gedung';
    protected $primaryKey = 'id_gedung';
    protected $fillable = [
        'id_barang',
        'register',
        'kondisi_bangunan',
        'bertingkat',
        'beton',
        'luas_lantai',
        'tahun_pembangunan',
        'lokasi_alamat',
        'tanggal_dokumen',
        'nomor_dokumen',
        'luas_tanah',
        'status_tanah',
        'kode_tanah',
        'asal_usul'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}