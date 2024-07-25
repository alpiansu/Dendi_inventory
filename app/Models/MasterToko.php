<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterToko extends Model
{
    public $timestamps = false;
    protected $table = 'master_toko';
    protected $fillable = ['nama_toko', 'initial_toko'];
    protected $primaryKey = 'id_toko';
}
