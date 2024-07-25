<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    public $timestamps = false;
    protected $table = 'masterbarang'; // Sesuaikan dengan nama tabel yang sebenarnya
    protected $fillable = ['KodeBarang', 'NamaItem', 'Harga', 'qty', 'addid', 'updid']; // Sesuaikan dengan nama kolom yang sebenarnya
    protected $primaryKey = 'KodeBarang';
    protected $keyType = 'string'; // Menyatakan bahwa primary key berupa string
}
