<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterSupplier;

class MasterSupplierController extends Controller
{
    public function index(Request $request)
    {
        try {
            $DataSupplier = MasterSupplier::all();
            return response()->json($DataSupplier, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function searchById(Request $request)
    {
        try {
            $DataSupplier = MasterSupplier::where('id_supp', $request->id_supp)->first();
            return response()->json($DataSupplier, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function create(Request $request)
    {
        try {
            MasterSupplier::create([
                'nama_supp' => $request->supplier_name,
                'initial_supp' => $request->supplier_init,
            ]);
            return response()->json('Data supplier baru berhasil disimpan!', 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }
}
