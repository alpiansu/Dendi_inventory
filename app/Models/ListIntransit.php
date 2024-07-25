<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListIntransit extends Model
{
    public $timestamps = false;
    protected $table = 'list_intransit';
    protected $primaryKey = 'id_insit';
}
