<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MasterBarang;
use App\Models\MasterAlat;
use App\Models\MasterTransaksi;

use PDF;

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
            'KodeBarang.*' => 'required|string|max:50|exists:masterbarang,KodeBarang',
            'Qty.*' => 'required|integer|min:1',
        ]);

        // Inisialisasi variabel
        $transaksiId = $request->input('transaksiId');
        $pengirim = $request->input('Pengirim');
        $kodeAlat = $request->input('kodeAlat');
        $kodeBarang = $request->input('KodeBarang');
        $qty = $request->input('Qty');

        try {
            DB::beginTransaction();
            $userId = auth()->id();
            $now = now();
            $barangDetails = [];
            foreach ($kodeBarang as $index => $barangKode) {
                $barang = MasterBarang::where('KodeBarang', $barangKode)->first();

                // Cek apakah barang ditemukan
                if (!$barang) {
                    throw new \Exception("Barang dengan kode $barangKode tidak ditemukan.");
                }

                // Buat entri baru di mastertransaksi
                $barangDetail = [
                    'TransaksiID' => $transaksiId,
                    'TipeTransaksi' => 'O',
                    'TanggalTransaksi' => $now->toDateString(),
                    'docno' => $transaksiId,
                    'KodeBarang' => $barangKode,
                    'Qty' => $qty[$index],
                    'Harga' => $barang->Harga,
                    'Pengirim' => $pengirim,
                    'KodeAlat' => $kodeAlat,
                    'UserID' => $userId,
                ];

                // Simpan ke database
                MasterTransaksi::create($barangDetail);
                $barangDetails[] = $barangDetail;

                // Update kuantitas di MasterBarang
                $barang->qty -= $qty[$index];
                $barang->save();
            }

            // Komit transaksi database
            DB::commit();

            // Setelah penyimpanan, buat PDF
            $dataBrg = MasterBarang::all();
            $namaAlat = MasterAlat::where('KodeAlat', $kodeAlat)->first();
            $data = [
                'docno' => $transaksiId,
                'transactionDate' => $now->toDateString(),
                'pengirim' => $pengirim,
                'barangDetails' => $barangDetails,
                'dataBrg' => $dataBrg,
                'kodeAlat' => $kodeAlat,
                'namaAlat' => $namaAlat,
            ];

            $pdf = PDF::loadView('pengeluaran.invoice_pemakaian', $data);

            // Tampilkan PDF di browser atau simpan dan download
            return $pdf->stream('invoice_pemakaian_barang_' . $transaksiId . '.pdf'); // atau gunakan download() untuk unduhan otomatis

            // return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
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
