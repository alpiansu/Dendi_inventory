<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MasterBarang;
use App\Models\MasterAlat;
use App\Models\MasterTransaksi;

class TransaksiPemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $masterBarangs = MasterBarang::all();
        $masterAlats = MasterAlat::all();
        return view('pengeluaran.create-pemakaian', compact('masterBarangs', 'masterAlats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'transaksiId' => 'required|string|max:25',
            'Pengirim' => 'required|string|max:255',
            'kodeAlat' => 'required|string|max:50',
            'KodeBarang.*' => 'required|string|max:50',
            'Qty.*' => 'required|integer|min:1',
        ]);

        // Inisialisasi variabel
        $transaksiId = $request->input('transaksiId');
        $pengirim = $request->input('Pengirim');
        $kodeAlat = $request->input('kodeAlat');
        $kodeBarang = $request->input('KodeBarang');
        $qty = $request->input('Qty');

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            foreach ($kodeBarang as $index => $barangKode) {
                $barang = MasterBarang::where('KodeBarang', $barangKode)->first();

                // Cek apakah barang ditemukan
                if (!$barang) {
                    throw new \Exception("Barang dengan kode $barangKode tidak ditemukan.");
                }

                // Buat entri baru di mastertransaksi
                MasterTransaksi::create([
                    'TransaksiID' => $transaksiId,
                    'TipeTransaksi' => 'O', // 'O' menandakan transaksi keluar
                    'TanggalTransaksi' => now(),
                    'docno' => $transaksiId,
                    'KodeBarang' => $barangKode,
                    'Qty' => $qty[$index],
                    'Harga' => $barang->Harga,
                    'Pengirim' => $pengirim,
                    'KodeAlat' => $kodeAlat,
                    'UserID' => auth()->user()->id, // Asumsikan ada authentication user
                ]);
            }

            // Komit transaksi database
            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
