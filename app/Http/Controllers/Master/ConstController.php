<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\TConst;

class ConstController extends Controller
{
    public function index()
    {
        $tConsts = TConst::all();

        return view('master.const.index', compact('tConsts'));
    }

    public function updateStatus($rkey)
    {
        try {
            $tConst = TConst::where('rkey', $rkey)->firstOrFail();

            // Update status to the opposite value (toggle)
            $tConst->status = !$tConst->status;
            $tConst->save();

            return redirect()->route('const.index')->with('success', 'Status berhasil diupdate.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('const.index')->with('error', 'Terjadi kesalahan. : ' . $errorMessage . ' Silakan coba lagi.');
        }
    }
}
