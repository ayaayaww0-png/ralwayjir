<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['kode_barang', 'nama_barang', 'id_kategori', 'stok_total', 'min_stok'];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function inventarisRuangan()
    {
        return $this->hasMany(InventarisRuangan::class, 'id_barang', 'id_barang');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'id_barang');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'id_barang');
    }

    public function mutasiBarang()
    {
        return $this->hasMany(MutasiBarang::class, 'id_barang', 'id_barang');
    }

    // Accessor untuk mengecek stok hampir habis
    public function getIsStokMenipisAttribute()
    {
        return $this->stok_total <= $this->min_stok;
    }
}