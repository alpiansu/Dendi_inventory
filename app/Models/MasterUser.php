<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MasterUser extends Authenticatable implements JWTSubject
{
    protected $table = 'master_users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    protected $fillable = ['username','nama_user','passw'];

     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
