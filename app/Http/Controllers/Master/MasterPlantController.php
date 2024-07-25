<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterPlant;

class MasterPlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterData = MasterPlant::all();
        return view('master.plant.index', compact('masterData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.plant.create');
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
                'KodePlant' => 'required|unique:masterplant,KodePlant',
                'NamaPlant' => 'required',
            ]);

            // Ambil user ID yang sedang terautentikasi
            $addid = Auth::id();

            // Simpan data
            $plant = new MasterPlant();
            $plant->KodePlant = $request->input('KodePlant');
            $plant->NamaPlant = $request->input('NamaPlant');
            $plant->addid = $addid; // Assign user ID ke addid
            $plant->save();

            // Redirect dengan pesan sukses
            return redirect()->route('master.plant.index')->with('success', 'Data plant berhasil disimpan.');
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
        $plant = MasterPlant::findOrFail($id);

        // Tampilkan view edit dengan data yang akan diedit
        return view('master.plant.edit', compact('plant'));
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
                'KodePlant' => 'required|unique:masterplant,KodePlant,' . $id . ',KodePlant',
                'NamaPlant' => 'required',
            ]);

            // Ambil user ID yang sedang terautentikasi
            $updid = Auth::id();

            // Cari data berdasarkan ID
            $plant = MasterPlant::findOrFail($id);

            // Update data
            $plant->KodePlant = $request->input('KodePlant');
            $plant->NamaPlant = $request->input('NamaPlant');
            $plant->updid = $updid;

            $plant->save();

            // Redirect dengan pesan sukses
            return redirect()->route('master.plant.index')->with('success', 'Data plant berhasil diperbarui.');
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
            $plant = MasterPlant::findOrFail($id);

            // Hapus data
            $plant->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('master.plant.index')->with('success', 'Data plant : ' . $id . ', berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani jika terjadi exception
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
