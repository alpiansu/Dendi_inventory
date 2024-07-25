<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTransaksi extends Model
{
    protected $table = 'mastertransaksi';
    protected $primaryKey = ['docno', 'KodeBarang', 'TipeTransaksi'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'TransaksiID',
        'TipeTransaksi',
        'TanggalTransaksi',
        'docno',
        'KodeBarang',
        'Qty',
        'Harga',
        'Pengirim',
        'KodeAlat',
        'UserID'
    ];

    // Define the default timestamp fields for create and update times
    const CREATED_AT = 'addtime';
    const UPDATED_AT = 'updtime';

    // Custom timestamps
    protected $dates = [
        'addtime',
        'updtime',
        'TanggalTransaksi',
    ];
}
