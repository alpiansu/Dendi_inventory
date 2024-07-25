<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterSupplier;

class MasterSupplierController extends Controller
{
    public function index()
    {
        $tokoList = MasterSupplier::all();
        return view('master.supplier.index', compact('tokoList'));
    }

    public function createForm()
    {
        return view('master.supplier.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_supp' => 'required',
                'initial_supp' => 'required',
            ]);

            MasterSupplier::create([
                'nama_supp' => $request->input('nama_supp'),
                'initial_supp' => $request->input('initial_supp'),
            ]);

            return redirect()->route('master.supplier.index')->with('success', 'Data supplier berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $toko = MasterSupplier::findOrFail($id);
            return view('master.supplier.edit', compact('toko'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data supplier.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required',
            'initial_toko' => 'required',
        ]);

        try {
            $toko = MasterSupplier::findOrFail($id);
            $toko->update($request->all());
            return redirect()->route('master.supplier.index')->with('success', 'Data supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data supplier.');
        }
    }

    public function destroy($id)
    {
        try {
            MasterSupplier::findOrFail($id)->delete();
            return redirect('/admin/master/toko')->with('success', 'Data toko berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/admin/master/toko')->with('error', 'Gagal menghapus data toko.');
        }
    }
}
