<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPlant extends Model
{
    public $timestamps = false;
    protected $table = 'masterplant';
    protected $fillable = ['KodePlant', 'NamaPlant', 'addid', 'updid'];
    protected $primaryKey = 'KodePlant';
    protected $keyType = 'string';
}
