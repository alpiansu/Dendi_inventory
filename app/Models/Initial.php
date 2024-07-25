<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Initial extends Model
{
    public $timestamps = false;
    protected $table = 'initial_so';
    protected $fillable = [
        'id_user',
        'tanggal',
        'token',
        'status',
    ];
    protected $primaryKey = 'id_initial_so';
    protected $keyType = 'string';
}
