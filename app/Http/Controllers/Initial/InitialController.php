<?php

namespace App\Http\Controllers\Initial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Initial;

class InitialController extends Controller
{
    public function index()
    {
        $initials = DB::select('SELECT id_initial_so, username, tanggal, nama_user, init.status, init.addtime FROM initial_so init LEFT JOIN master_users usr USING(id_user) WHERE usr.nama_user IS NOT NULL;');

        return view('initial.index', compact('initials'));
    }

    public function updateStatus($id)
    {
        try {
            $initial = Initial::findOrFail($id);

            // Update status to the opposite value (toggle)
            $initial->status = !$initial->status;
            $initial->save();

            return redirect()->route('initial.index')->with('success', 'Status berhasil diupdate.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('initial.index')->with('error', 'Terjadi kesalahan. : ' . $errorMessage . ' Silakan coba lagi.');
        }
    }
}
