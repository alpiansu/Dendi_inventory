<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterToko;

class MasterTokoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $DataToko = MasterToko::all();
            return response()->json($DataToko, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }

    public function searchById(Request $request)
    {
        try {
            $DataToko = MasterToko::where('id_toko', $request->id_toko)->first();
            return response()->json($DataToko, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 401);
        }
    }
}
