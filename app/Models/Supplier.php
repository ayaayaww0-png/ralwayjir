<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id_supplier';
    protected $fillable = ['nama_supplier'];

    // HAPUS relasi ini karena sudah tidak ada id_supplier di inventaris_ruangans
    // public function inventarisRuangan()
    // {
    //     return $this->hasMany(InventarisRuangan::class, 'id_supplier', 'id_supplier');
    // }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier', 'id_supplier');
    }
}