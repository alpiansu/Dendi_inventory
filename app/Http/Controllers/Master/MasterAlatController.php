<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterAlat;
use App\Models\MasterPlant;
use Illuminate\Support\Facades\DB;

class MasterAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterData = DB::table('masteralat')
            ->leftJoin('masterplant', 'masteralat.KodePlant', '=', 'masterplant.KodePlant')
            ->select('masteralat.*', 'masterplant.NamaPlant')
            ->get();
        return view('master.alat.index', compact('masterData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $masterPlant = MasterPlant::all();
        return view('master.alat.create', compact('masterPlant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'KodeAlat' => 'required|unique:masteralat,KodeAlat',
                'NamaAlat' => 'required',
                'KodePlant' => 'required',
            ]);

            // Ambil user ID yang sedang terautentikasi
            $addid = Auth::id();

            // Simpan data
            $alat = new MasterAlat();
            $alat->KodeAlat = $request->input('KodeAlat');
            $alat->NamaAlat = $request->input('NamaAlat');
            $alat->KodePlant = $request->input('KodePlant');
            $alat->addid = $addid; // Assign user ID ke addid
            $alat->save();

            // Redirect dengan pesan sukses
            return redirect()->route('master.alat.index')->with('success', 'Data alat berhasil disimpan.');
        } catch (\Exception $e) {
            // Tangani jika terjadi exception
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Cari data MasterAlat berdasarkan ID
        $alat = MasterAlat::findOrFail($id);
        $masterPlant = MasterPlant::all();

        // Tampilkan view edit dengan data yang akan diedit
        return view('master.alat.edit', compact('alat', 'masterPlant'));
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
        try {
            // Validasi input
            $request->validate([
                'KodeAlat' => 'required|unique:masteralat,KodeAlat,' . $id . ',KodeAlat',
                'NamaAlat' => 'required',
                'KodePlant' => 'required',
            ]);

            // Ambil user ID yang sedang terautentikasi
            $updid = Auth::id();

            // Cari data berdasarkan ID
            $alat = MasterAlat::findOrFail($id);

            // Update data
            $alat->KodeAlat = $request->input('KodeAlat');
            $alat->NamaAlat = $request->input('NamaAlat');
            $alat->KodePlant = $request->input('KodePlant');
            $alat->updid = $updid;

            $alat->save();

            // Redirect dengan pesan sukses
            return redirect()->route('master.alat.index')->with('success', 'Data alat berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani jika terjadi exception
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()]);
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
            // Cari data MasterAlat berdasarkan ID
            $alat = MasterAlat::findOrFail($id);

            // Hapus data
            $alat->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('master.alat.index')->with('success', 'Data alat : ' . $id . ', berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani jika terjadi exception
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
