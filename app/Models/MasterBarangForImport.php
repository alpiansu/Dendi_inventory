<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarangForImport extends Model
{
    public $timestamps = false;
    protected $table = 'master_barang';
    protected $fillable = ['kode_barang', 'nama_barang', 'jenis', 'satuan', 'merek', 'satuan_dasar', 'konversi_satuan_dasar', 'harga_pokok', 'harga_jual', 'stok_minimum', 'tipe_item', 'menggunakan_serial', 'rak', 'kode_gudang_kantor', 'kode_supplier', 'keterangan'];
    protected $primaryKey = 'kode_barang';
}
