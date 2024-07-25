<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_const extends Model
{
    protected $table = 'const';
    protected $primaryKey = 'rkey';
    public $timestamps = false;
    protected $keyType = 'string';
}
