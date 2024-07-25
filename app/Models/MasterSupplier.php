<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSupplier extends Model
{
    public $timestamps = false;
    protected $table = 'master_supplier';
    protected $fillable = ['nama_supp', 'initial_supp'];
    protected $primaryKey = 'id_supp';
}
