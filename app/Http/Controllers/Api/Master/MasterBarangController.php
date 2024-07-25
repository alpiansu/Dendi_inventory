<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBarang;
use App\Models\MasterBarcode;
use App\Models\MasterBarangView;

class MasterBarangController extends Controller
{
    public function search(Request $request)
    {
        try {
            $keySearch = $request->keysearch;
            $DataBarang = MasterBarangView::select(
                '*',
                DB::raw('CAST(HARGA_POKOK AS DECIMAL(17,0)) AS harga_pokok_int')
            )->where('NAMA_BARANG', 'like', '%' . $keySearch . '%')->get();
            return response()->json($DataBarang, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function create(Request $request)
    {
        try {
            $barcode = $request->barcode;
            $namaBarang = $request->nama_barang;
            $Harga = $request->harga;
            $saveBarang = MasterBarang::create([
                'kode_barang' => $barcode,
                'nama_barang' => $namaBarang,
                'harga_pokok' => $Harga,
            ]);

            if ($saveBarang) {
                $mstrBarcode = MasterBarcode::create([
                    'id_barang' => $saveBarang->id_barang,
                    'barcode1' => $barcode,
                ]);
            }

            return response()->json('Data Barang ' . $namaBarang . ' Berhasil di simpan!', 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }
}
