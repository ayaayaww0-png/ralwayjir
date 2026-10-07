<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangHabisPakai extends Model
{
    protected $table = 'barang_habis_pakai';
    protected $fillable = [
        'tahun',
        'nama_barang',
        'sisa_awal',
        'jan_m', 'jan_k', 'jan_jml', 'jan_sisa',
        'feb_m', 'feb_k', 'feb_jml', 'feb_sisa',
        'mar_m', 'mar_k', 'mar_jml', 'mar_sisa',
        'apr_m', 'apr_k', 'apr_jml', 'apr_sisa',
        'mei_m', 'mei_k', 'mei_jml', 'mei_sisa',
        'jun_m', 'jun_k', 'jun_jml', 'jun_sisa',
        'jul_m', 'jul_k', 'jul_jml', 'jul_sisa',
        'agu_m', 'agu_k', 'agu_jml', 'agu_sisa',
        'sep_m', 'sep_k', 'sep_jml', 'sep_sisa',
        'okt_m', 'okt_k', 'okt_jml', 'okt_sisa',
        'nov_m', 'nov_k', 'nov_jml', 'nov_sisa',
        'des_m', 'des_k', 'des_jml', 'des_sisa',
    ];
}