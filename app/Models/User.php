<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Tentukan nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'masteruser';

    /**
     * Tentukan primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'UserID';

    /**
     * Tentukan apakah primary key menggunakan auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Tentukan tipe data dari primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserID', 'NamaUser', 'email', 'Pass',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Pass',
    ];

    public $timestamps = false;

    /**
     * Menentukan nama kolom password.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->Pass;
    }
}
