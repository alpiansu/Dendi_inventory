<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CekTroli extends Model
{
    public $timestamps = false;
    protected $table = 'cek_bbl_troli_view';
    protected $primaryKey = 'id_troli';
}
