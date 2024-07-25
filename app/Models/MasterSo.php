<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSo extends Model
{
    public $timestamps = false;
    protected $table = 'master_so';
    protected $fillable = ['tanggal', 'mulai', 'status','addid'];
    protected $primaryKey = 'id_so';
    protected $keyType = 'string';
}
