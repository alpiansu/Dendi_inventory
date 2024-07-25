<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarcode extends Model
{
    protected $table = 'masterbarcode';
    protected $primaryKey = ['KodeBarang', 'kodeJenis'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'BarcodeID',
        'KodeBarang',
        'kodeJenis',
        'BarcodeBarang',
        'addid',
        'updid',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->BarcodeID = static::generateBarcodeID();
        });

        static::updating(function ($model) {
            $model->updtime = now();
        });
    }

    protected static function generateBarcodeID()
    {
        $lastBarcode = static::orderBy('BarcodeID', 'desc')->first();

        if (!$lastBarcode) {
            return 'BAR00001';
        }

        $lastNumber = intval(substr($lastBarcode->BarcodeID, 3));
        $newNumber = $lastNumber + 1;

        return 'BAR' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
