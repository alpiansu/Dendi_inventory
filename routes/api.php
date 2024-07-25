<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;


// Api
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\StockOpname\SOController;
use App\Http\Controllers\Api\Initial\InitialController;

use App\Http\Controllers\Api\Master\MasterTokoController;
use App\Http\Controllers\Api\NPB\NpbController;
use App\Http\Controllers\Api\Bbl\BblController;
use App\Http\Controllers\Api\Master\MasterBarangController;
use App\Http\Controllers\Api\Master\MasterSupplierController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test-validation', function (Request $request) {
    return response()->json('OK!', 200);
});

Route::post('/login', ApiLoginController::class);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/checkToken', function () {
        return response()->json(['message' => 'Token Valid']); //message dan result 'Token Valid' dijadikan acuan di mobile app
    });

    Route::post('/initial/create', [InitialController::class, 'create']);
    Route::post('/initial/check', [InitialController::class, 'check']);

    Route::get('/stockopname/approval', [SOController::class, 'approval']);
    Route::get('/stockopname/cekmasterso', [SOController::class, 'cekmasterso']);
    Route::get('/stockopname/ambilidmasterso', [SOController::class, 'ambilidmasterso']);
    Route::post('/stockopname/scanbrg', [SOController::class, 'scanbrg']);

    //SoPembelianApk
    Route::get('/master/toko', [MasterTokoController::class, 'index']);
    Route::post('/master/toko/sIdToko', [MasterTokoController::class, 'searchById']);
    Route::post('/master/npb/insit', [NpbController::class, 'infoInsit']);

    Route::post('/master/barang/search', [MasterBarangController::class, 'search']);
    Route::post('/master/barang/input', [MasterBarangController::class, 'create']);

    Route::get('/master/supplier', [MasterSupplierController::class, 'index']);
    Route::post('/master/supplier/sIdSupp', [MasterSupplierController::class, 'searchById']);
    Route::post('/master/supplier/create', [MasterSupplierController::class, 'create']);

    Route::post('/penerimaan/scan/infoinsit', [NpbController::class, 'getInsit']);
    Route::post('/penerimaan/scan', [NpbController::class, 'scanPenerimaan']);
    Route::post('/penerimaan/getdatainsit', [NpbController::class, 'getDataInsit']);

    Route::post('/pembelian/troli', [BblController::class, 'getTroli']);
    Route::post('/pembelian/cetakBeli', [BblController::class, 'cetakBeli']);
    Route::post('/pembelian/scan', [BblController::class, 'scanPembelian']);
    Route::post('/pembelian/searchName', [BblController::class, 'searchName']);
    Route::post('/pembelian/savetroli', [BblController::class, 'saveToTroli']);
    Route::delete('/pembelian/deleteTroli/{idTroli}/{idToko}/{idBarang}', [BblController::class, 'deleteTroli']);
    Route::post('/pembelian/saveTransaksi', [BblController::class, 'saveTransaksi']);

    // Dan lain-lain...
});
