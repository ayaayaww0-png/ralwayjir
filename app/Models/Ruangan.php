<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';
    protected $primaryKey = 'id_ruangan';
    protected $fillable = ['nama_ruangan'];

    public function inventarisRuangan()
    {
        return $this->hasMany(InventarisRuangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_ruangan', 'id_ruangan');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_ruangan', 'id_ruangan');
    }

    public function mutasiAsal()
    {
        return $this->hasMany(MutasiBarang::class, 'id_ruangan_asal', 'id_ruangan');
    }

    public function mutasiTujuan()
    {
        return $this->hasMany(MutasiBarang::class, 'id_ruangan_tujuan', 'id_ruangan');
    }
}