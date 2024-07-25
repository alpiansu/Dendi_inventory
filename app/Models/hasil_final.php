<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil_final extends Model
{
    public $timestamps = false;
    protected $table = 'hasil_final';
    protected $primaryKey = 'kode_item';
    protected $keyType = 'string';
}
