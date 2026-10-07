<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuks';
    protected $primaryKey = 'id_masuk';
    protected $fillable = [
        'tanggal',
        'id_barang',
        'id_supplier',
        'id_ruangan',
        'jumlah',
        'harga_beli'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga_beli' => 'integer',
        'jumlah' => 'integer',
    ];

    // ===== RELASI =====
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    // ===== ACCESSOR (Otomatis Hitung Total) =====
    public function getTotalNilaiAttribute()
    {
        return $this->jumlah * $this->harga_beli;
    }

    // Format harga
    public function getHargaBeliFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    public function getTotalNilaiFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_nilai, 0, ',', '.');
    }
}