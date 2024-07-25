<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterToko;

class MasterTokoController extends Controller
{
    public function index()
    {
        $tokoList = MasterToko::all();
        return view('master.toko.index', compact('tokoList'));
    }

    public function createForm()
    {
        return view('master.toko.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_toko' => 'required',
                'initial_toko' => 'required',
            ]);

            MasterToko::create([
                'nama_toko' => $request->input('nama_toko'),
                'initial_toko' => $request->input('initial_toko'),
            ]);

            return redirect('/admin/master/toko')->with('success', 'Data toko berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect('/admin/master/toko/create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $toko = MasterToko::findOrFail($id);
            return view('master.toko.edit', compact('toko'));
        } catch (\Exception $e) {
            return redirect('/admin/master/toko')->with('error', 'Gagal mengambil data toko.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required',
            'initial_toko' => 'required',
        ]);

        try {
            $toko = MasterToko::findOrFail($id);
            $toko->update($request->all());
            return redirect('/admin/master/toko')->with('success', 'Data toko berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect('/admin/master/toko')->with('error', 'Gagal memperbarui data toko.');
        }
    }

    public function destroy($id)
    {
        try {
            MasterToko::findOrFail($id)->delete();
            return redirect('/admin/master/toko')->with('success', 'Data toko berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/admin/master/toko')->with('error', 'Gagal menghapus data toko.');
        }
    }
}
