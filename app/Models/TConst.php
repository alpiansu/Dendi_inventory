<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TConst extends Model
{
    protected $table = 'const';
    protected $primaryKey = 'rkey';
    public $timestamps = false;
    protected $keyType = 'string';
}
