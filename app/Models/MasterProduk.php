<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProduk extends Model
{
    public $timestamps = false;
    protected $fillable = ['kode_item', 'barcode', 'nama_barang', 'qty'];
    protected $primaryKey = 'kode_item';
    protected $keyType = 'string';
}
