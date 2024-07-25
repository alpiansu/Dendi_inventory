<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterJenisBarcode;

class MasterJenisBarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterData = MasterJenisBarcode::all();
        return view('master.jenis_barcode.index', compact('masterData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.jenis_barcode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'kodeJenis' => 'required|string|max:10|unique:master_jenis_barcode,kodeJenis',
            'JenisBarcode' => 'required|string|max:50',
        ]);

        try {
            // Membuat instance baru dari MasterJenisBarcode
            $jenisBarcode = new MasterJenisBarcode([
                'kodeJenis' => $request->kodeJenis,
                'JenisBarcode' => $request->JenisBarcode,
            ]);

            // Menyimpan data ke database
            $jenisBarcode->save();

            // Redirect ke halaman yang diinginkan setelah penyimpanan berhasil
            return redirect()->route('master.barcode.index')->with('success', 'Jenis Barcode berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengembalikan pesan error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
        $masterData = MasterJenisBarcode::findOrFail($id);
        return view('master.jenis_barcode.edit', compact('masterData'));
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
        // Validasi data yang diterima
        $request->validate([
            'kodeJenis' => 'required|string|max:10|unique:master_jenis_barcode,kodeJenis,' . $id . ',kodeJenis',
            'JenisBarcode' => 'required|string|max:50',
        ]);

        try {
            // Mencari data yang akan di-update
            $jenisBarcode = MasterJenisBarcode::findOrFail($id);

            // Mengupdate data
            $jenisBarcode->kodeJenis = $request->kodeJenis;
            $jenisBarcode->JenisBarcode = $request->JenisBarcode;
            $jenisBarcode->save();

            return redirect()->route('master.barcode.index')->with('success', 'Jenis Barcode berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengupdate Jenis Barcode: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $barang = MasterJenisBarcode::findOrFail($id);
            $barang->delete();

            return redirect()->route('master.barcode.index')->with('success', 'Data barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data barang: ' . $e->getMessage()]);
        }
    }
}
