<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarangView extends Model
{
    public $timestamps = false;
    protected $table = 'master_barang_view';
    protected $primaryKey = 'id_barang';
}
