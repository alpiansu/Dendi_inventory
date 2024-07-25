<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Npb extends Model
{
    protected $table = 'insit_npb';
    public $timestamps = false;

    protected $fillable = [
        'id_insit',
        'tanggal',
        'docno',
        'id_toko',
        'id_barang',
        'qty',
        'harga_beli',
        'gross_beli',
        'addid',
        'updid',
    ];
    // protected $primaryKey = ['id_insit'];
}
