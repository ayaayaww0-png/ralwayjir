<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarisRuangan extends Model
{
    protected $table = 'inventaris_ruangans';
    protected $primaryKey = 'id_inventaris';
    protected $fillable = ['id_supplier', 'id_barang', 'id_ruangan', 'kondisi', 'stok'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}