<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cetak_selisih extends Model
{
    public $timestamps = false;
    protected $table = 'cetak_selisih';
    protected $primaryKey = 'kode_item';
    protected $keyType = 'string';
}
