<?php

namespace App\Http\Controllers\Api\StockOpname;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

use App\Models\MasterSo;
use App\Models\Initial;
use App\Models\DetailSo;
use App\Models\MasterProduk;

class SOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function ambilidmasterso(Request $request)
    {
        try {
            $cekSoAktif = MasterSO::where('status', '0')->first();
            return response()->json($cekSoAktif->id_so, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function scanbrg(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);
            $idInitial = $this->getidInitial($idUser);

            $barcode = $request->barcode;
            $id_master_so = $request->id_master_so;
            $qty = $request->qty;

            $updateQtyScan = DetailSo::where('barcode', $barcode)
                ->where('id_so', $id_master_so)
                ->first(); // Menggunakan first() untuk mendapatkan satu baris data

            if ($updateQtyScan) {
                // Memeriksa apakah nilai yang akan diupdate berbeda dengan nilai yang sudah ada
                if ($updateQtyScan->qty != $qty || $updateQtyScan->id_initial_so != $idInitial) {
                    // Melakukan update hanya jika ada perubahan nilai
                    DetailSo::where('barcode', $barcode)
                        ->where('id_so', $id_master_so)
                        ->update([
                            'qty' => $qty,
                            'id_initial_so' => $idInitial
                        ]);

                    return response()->json('Berhasil di simpan!', 200);
                } else {
                    return response()->json('Barang tersebut sudah pernah discan dan nilainya sama persis.', 201);
                }
            } else {
                return response()->json('Tidak ditemukan barcode ' . $barcode . ' pada id ' . $id_master_so . ' master stock opname!', 201);
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function insertMasterDetailSO()
    {
        try {
            //ambil id so dari table master so yang baru saja diinsert
            $dataSoAktif = MasterSo::where('tanggal', Carbon::now()->format('Y-m-d'))->where('status', '0')->first();
            if ($dataSoAktif) {
                $idMasterSo = $dataSoAktif->id_so;
                $masterProduk = MasterProduk::get();
                foreach ($masterProduk as $dataProduk) {
                    DetailSo::create([
                        'id_so' => $idMasterSo,
                        'barcode' => ($dataProduk->barcode != '' ? $dataProduk->barcode : $dataProduk->kode_item),
                        'com' => $dataProduk->qty,
                        'qty' => '0',
                    ]);
                }
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function initiateso($idInitial)
    {
        try {
            MasterSo::create([
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'mulai' => Carbon::now(),
                'status' => '0',
                'addid' => 'MobApp@' . ($idInitial ?? ''),
            ]);
            $this->insertMasterDetailSO();
            return true;
        } catch (\Exception $err) {
            throw $err;
        }
    }

    public function cekmasterso(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);
            $idInitial = $this->getidInitial($idUser);

            $cekSoAktif = MasterSO::where('status', '0')->count();
            if ($cekSoAktif >= 1) {
                return response()->json('continue', 200);
            } else {
                $initialMasterSo = $this->initiateso($idInitial);
                if ($initialMasterSo) {
                    return response()->json('new', 200);
                } else {
                    return response()->json('Terjadi kesalahan pada saat akan membuat master so baru!', 401);
                }
            }
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function getidInitial($idUser)
    {
        try {
            $idInitial = Initial::where('tanggal', Carbon::now()->format('Y-m-d'))
                ->where('id_user', $idUser)->first();
            return $idInitial->id_initial_so;
        } catch (\Exception $err) {
            return response()->json(['error' => $err], 401);
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

    /**
     * Approval sebelum SO
     *
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {
        try {
            $strToken = $request->header('Authorization');
            $idUser = $this->getUserInfo($strToken);
            $passInitial = Initial::where('id_user', $idUser)->where('tanggal', Carbon::now()->format('Y-m-d'))->where('status', '1')->count();
            if ($passInitial == 1) {
                return response()->json(['message' => 'approved'], 200);
            } else {
                return response()->json(['message' => 'forbidden'], 403);
            }
        } catch (\Exception $er) {
            return response()->json($er, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
