<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSo extends Model
{
    public $timestamps = false;
    protected $table = 'detail_so';
    protected $fillable = [
        'id_so',
        'barcode',
        'com',
        'qty',
        'id_initial_so',
    ];
}
