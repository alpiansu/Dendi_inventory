<?php

namespace App\Http\Controllers\Penerimaan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterTransaksi;
use App\Models\MasterBarang;
use PDF;

class TransaksiPenerimaanController extends Controller
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
        return view('penerimaan.create', compact('masterBarangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'docno' => 'required|string|max:25',
            'KodeBarang.*' => 'required|string|exists:masterbarang,KodeBarang',
            'Qty.*' => 'required|integer|min:1',
            'pengirim' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $now = now();
            $userId = auth()->id();

            $barangDetails = [];
            foreach ($request->KodeBarang as $key => $kodeBarang) {
                $barangDetails[] = [
                    'docno' => $request->docno,
                    'KodeBarang' => $kodeBarang,
                    'Qty' => $request->Qty[$key],
                    'Harga' => $request->Harga[$key],
                    'TipeTransaksi' => 'I',
                    'TanggalTransaksi' => $now->toDateString(),
                    'Pengirim' => $request->pengirim,
                    'UserID' => $userId,
                    'TransaksiID' => $request->transaksiId,
                ];

                // Update kuantitas di MasterBarang
                $barang = MasterBarang::find($kodeBarang);
                $qtyAwal = intval($barang->qty ?? 0);
                $qtyTambah = intval($request->Qty[$key]);

                $barang->qty = $qtyAwal + $qtyTambah;
                $barang->save();
            }

            DB::table('mastertransaksi')->insert($barangDetails);

            // Setelah penyimpanan, buat PDF
            $dataBrg = MasterBarang::all();
            $data = [
                'docno' => $request->docno,
                'pengirim' => $request->pengirim,
                'barangDetails' => $barangDetails, // Data detail barang yang disimpan
                'dataBrg' => $dataBrg,
            ];

            $pdf = PDF::loadView('penerimaan.invoice_terima', $data);

            DB::commit();
            // Tampilkan PDF di browser atau simpan dan download
            return $pdf->stream('invoice_terima_barang_' . $request->docno . '.pdf'); // atau use download() untuk unduhan otomatis
            // return redirect()->back()->with('success', 'Transaksi penerimaan barang berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }

    public function generateTransaksiID($tipeTransaksi)
    {
        $lastTransaction = MasterTransaksi::where('TipeTransaksi', $tipeTransaksi)
            ->orderBy('TransaksiID', 'desc')
            ->first();

        if (!$lastTransaction) {
            return 'TRAN-' . $tipeTransaksi . '-00001';
        } else {
            $lastID = intval(substr($lastTransaction->TransaksiID, 8));
            $newID = $lastID + 1;
            return response()->json(['transaksiId' => 'TRAN-' . $tipeTransaksi . '-' . str_pad($newID, 5, '0', STR_PAD_LEFT)]);
        }
    }

    public function getHarga($kodeBarang)
    {
        $barang = MasterBarang::find($kodeBarang);
        return response()->json(['harga' => $barang->Harga]);
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
