<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAlat extends Model
{
    public $timestamps = false;
    protected $table = 'masteralat';
    protected $fillable = ['KodeAlat', 'NamaAlat', 'KodePlant', 'addid', 'updid'];
    protected $primaryKey = 'KodeAlat';
    protected $keyType = 'string';
}
