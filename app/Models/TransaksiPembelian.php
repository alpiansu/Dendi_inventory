<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    public $timestamps = false;
    protected $table = 'transaksi_pembelian';
    protected $fillable = ['tanggal', 'id_barang', 'qty', 'harga_beli', 'gross_beli', 'tipe_beli', 'id_user', 'invno', 'inv_date'];
}
