<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id_supplier';
    protected $fillable = ['nama_supplier'];

    public function inventarisRuangan()
    {
        return $this->hasMany(InventarisRuangan::class, 'id_supplier', 'id_supplier');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier', 'id_supplier');
    }
}