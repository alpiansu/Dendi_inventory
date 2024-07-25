<?php

namespace App\Http\Controllers\Api\NPB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ListIntransit;
use App\Models\ScanTerimaBarang;
use App\Models\TransaksiPembelian;
use App\Models\Npb;
use App\Models\HistoryPenerimaan;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class NpbController extends Controller
{
    public function infoInsit(Request $request)
    {
        try {
            $idToko = $request->id_toko;
            $DataNpb = ListIntransit::where('id_toko', $idToko)->get();
            return response()->json($DataNpb, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function getInsit(Request $request)
    {
        try {
            $idInsit = $request->id_insit;
            $SisaInsit = ListIntransit::where('id_insit', $idInsit)->get();
            return response()->json($SisaInsit, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function getDataInsit(Request $request)
    {
        try {
            $xidInsit = $request->id_insit;
            $dataNPB = HistoryPenerimaan::where('NO_NPB', $xidInsit)->get();
            return response()->json($dataNPB, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function scanPenerimaan(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);

            $barcode = $request->barcode;
            $idInsit = $request->id_insit;
            $qty = $request->qty;
            $tipeBeli = 'NPB';

            $idPembelian = TransaksiPembelian::max('id') + 1;

            $scanBarangTerima = ScanTerimaBarang::where(function ($query) use ($barcode, $idInsit) {
                $query->where('barcode1', $barcode)
                    ->where('invno', $idInsit)
                    ->orWhere('barcode2', $barcode)
                    ->where('invno', $idInsit)
                    ->orWhere('barcode3', $barcode)
                    ->where('invno', $idInsit);
            })->first();

            if ($scanBarangTerima) {
                $gross = $qty * $scanBarangTerima->harga_beli;
                $insertTransaksi = TransaksiPembelian::updateOrInsert(
                    [
                        'tanggal' => Carbon::now()->format('Y-m-d'),
                        'id_barang' => $scanBarangTerima->id_barang,
                        'id_toko' => $scanBarangTerima->id_toko,
                        'invno' => $scanBarangTerima->invno,
                    ],
                    [
                        'id' => $idPembelian,
                        'qty' => $qty,
                        'harga_beli' => $scanBarangTerima->harga_beli,
                        'gross_beli' => $gross,
                        'id_user' => $idUser,
                        'inv_date' => $scanBarangTerima->inv_date,
                        'tipe_beli' => $tipeBeli
                    ]
                );

                if ($insertTransaksi) {
                    Npb::where('id_insit', $scanBarangTerima->invno)
                        ->where('id_barang', $scanBarangTerima->id_barang)
                        ->update([
                            'recid' => '1'
                        ]);
                }

                return response()->json('Berhasil di simpan!', 200);
            } else {
                return response()->json('Tidak ditemukan barcode ' . $barcode . ' pada ID NPB ' . $idInsit . '!', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function getUserInfo($strToken)
    {
        try {
            if (!$strToken) {
                return response()->json(['error' => 'Token not provided'], 401);
            }
            $jwtToken = substr($strToken, 7);
            $id_user = JWTAuth::parseToken($jwtToken)->getPayload()->get('id_user');
            return $id_user;
        } catch (\Exception $err) {
            return response()->json(['error' => $err], 401);
        }
    }
}
