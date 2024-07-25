<?php

namespace App\Http\Controllers\Api\Bbl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CekTroli;
use App\Models\BblTroli;
use App\Models\MasterBarang;
use App\models\TransaksiPembelian;
use App\Models\ScanPembelianBarang;
use App\Models\CetakTransaksiPembelian;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class BblController extends Controller
{
    public function getTroli(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);
            $idSupplier = $request->id_supp;

            $idTroliNew = BblTroli::max('id_troli') + 1;
            $DataBblTroli = CekTroli::where('id_user', $idUser)
                ->where('id_supp', $idSupplier)
                ->where('recid', '*')->get();
            if ($DataBblTroli->count() > 0) {
                return response()->json($DataBblTroli, 200);
            } else {
                $emptyData = [
                    [
                        'id_troli' => $idTroliNew,
                    ],
                ];
                return response()->json($emptyData, 200);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function cetakBeli(Request $request)
    {
        try {
            $idSupplier = $request->id_supp;
            $xIdTroli = $request->id_troli;
            $tipeBeli = 'BBL';

            $dataTarikan = CetakTransaksiPembelian::where('id_toko', $idSupplier)
                ->where('invno', $xIdTroli)
                ->where('tipe_beli', $tipeBeli)
                ->get();
            if ($dataTarikan) {
                return response()->json($dataTarikan, 200);
            } else {
                return response()->json('Coba liat ini ' . $idSupplier . ' - ' . $xIdTroli, 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function scanPembelian(Request $request)
    {
        try {
            $barcode = $request->barcode;
            $scanPembelianBarang = ScanPembelianBarang::where(function ($query) use ($barcode) {
                $query->where(function ($subquery) use ($barcode) {
                    $subquery->whereNotNull('barcode1')
                        ->where('barcode1', $barcode);
                })
                    ->orWhere(function ($subquery) use ($barcode) {
                        $subquery->whereNotNull('barcode2')
                            ->where('barcode2', $barcode);
                    })
                    ->orWhere(function ($subquery) use ($barcode) {
                        $subquery->whereNotNull('barcode3')
                            ->where('barcode3', $barcode);
                    });
            })->first();


            if ($scanPembelianBarang && $barcode != '') {
                // Memeriksa apakah nilai yang akan diupdate berbeda dengan nilai yang sudah ada
                return response()->json($scanPembelianBarang, 200);
            } elseif (!$scanPembelianBarang && $barcode != '') {
                return response()->json('Tidak ditemukan barcode ' . $barcode . ' pada master barang!', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function searchName(Request $request)
    {
        try {
            $NamaBarang = $request->nama_barang;
            $scanPembelianBarang = ScanPembelianBarang::where('nama_barang', 'like', '%' . $NamaBarang . '%')->get();
            if ($scanPembelianBarang) {
                // Memeriksa apakah nilai yang akan diupdate berbeda dengan nilai yang sudah ada
                return response()->json($scanPembelianBarang, 200);
            } else {
                return response()->json('Tidak ditemukan Nama Barang ' . $NamaBarang . ' pada master barang!', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function saveToTroli(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);
            $idTroli = $request->id_troli;

            $insertTroli = BblTroli::updateOrInsert(
                [
                    'id_troli' => $idTroli,
                    'id_supp' => $request->id_toko,
                    'recid' => '*',
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                    'id_barang' => $request->id_barang,
                    'id_user' => $idUser,
                ],
                [
                    'qty' => $request->qty,
                    'harga_barang' => $request->harga,
                ]
            );

            if ($insertTroli) {
                return response()->json('Berhasil di simpan!', 200);
            } else {
                return response()->json('Gagal menyimpan!', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function saveTransaksi(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);

            $idToko = $request->id_toko;
            $tipeBeli = 'BBL';

            $DataBblTroli = CekTroli::where('id_user', $idUser)
                ->where('id_supp', $idToko)
                ->where('recid', '*')->get();

            if ($DataBblTroli->isNotEmpty()) {
                $idTransaksi = 1;
                $cekData = TransaksiPembelian::where('id_toko', $DataBblTroli[0]->id_supp)
                    ->where('invno', $DataBblTroli[0]->id_troli)
                    ->where('tipe_beli', $tipeBeli)
                    ->count();
                if ($cekData > 0) {
                    $idLama = TransaksiPembelian::where('id_toko', $DataBblTroli[0]->id_supp)
                        ->where('invno', $DataBblTroli[0]->id_troli)
                        ->where('tipe_beli', $tipeBeli)
                        ->max('id');
                    $idTransaksi = $idLama;
                } else {
                    $idPembelian = TransaksiPembelian::max('id') + 1;
                    if ($idPembelian != 1) {
                        $idTransaksi = $idPembelian;
                    }
                }

                foreach ($DataBblTroli as $troliItem) {

                    $insertTransaksi = TransaksiPembelian::updateOrInsert(
                        [
                            'id_barang' => $troliItem->id_barang,
                            'id_toko' => $troliItem->id_supp,
                            'invno' => $troliItem->id_troli,
                            'tipe_beli' => $tipeBeli
                        ],
                        [
                            'tanggal' => Carbon::now()->format('Y-m-d'),
                            'qty' => $troliItem->qty,
                            'id' => $idTransaksi,
                            'harga_beli' => $troliItem->harga_pokok,
                            'gross_beli' => $troliItem->gross,
                            'id_user' => $idUser,
                            'inv_date' => $troliItem->tanggal,
                        ]
                    );

                    if ($insertTransaksi) {
                        BblTroli::where('id_troli', $troliItem->id_troli)
                            ->where('id_barang', $troliItem->id_barang)
                            ->where('id_supp', $troliItem->id_supp)
                            ->update([
                                'recid' => '1'
                            ]);

                        MasterBarang::where('id_barang', $troliItem->id_barang)
                            ->update([
                                'harga_pokok' => $troliItem->harga_pokok
                            ]);
                    }
                }

                return response()->json('Berhasil di simpan!', 200);
            } else {
                return response()->json('Terjadi masalah saat menyimpan data troli ke transaksi', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function deleteTroli($idTroli, $idToko, $idBarang)
    {
        try {
            $deleteTroli = BblTroli::where([
                'id_troli' => $idTroli,
                'id_toko' => $idToko,
                'id_barang' => $idBarang,
            ])->delete();

            if ($deleteTroli) {
                return response()->json('Berhasil di hapus!', 200);
            } else {
                return response()->json('Gagal menghapus!' . $idTroli . ' - ' . $idToko . ' - ' . $idBarang, 201);
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
