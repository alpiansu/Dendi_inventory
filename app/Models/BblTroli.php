<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BblTroli extends Model
{
    public $timestamps = false;
    protected $table = 'bbl_troli';
    protected $fillable = ['id_troli', 'id_supp', 'recid', 'tanggal', 'id_barang', 'qty', 'id_user', 'addid', 'updid'];
    protected $primaryKey = 'id_troli';
}
