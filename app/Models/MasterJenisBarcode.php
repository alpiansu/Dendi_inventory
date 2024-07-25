<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJenisBarcode extends Model
{
    public $timestamps = false;
    protected $table = 'master_jenis_barcode'; // Sesuaikan dengan nama tabel yang sebenarnya
    protected $fillable = ['kodeJenis', 'JenisBarcode']; // Sesuaikan dengan nama kolom yang sebenarnya
    protected $primaryKey = 'kodeJenis';
    protected $keyType = 'string'; // Menyatakan bahwa primary key berupa string
}
