<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterTransaksi;
use App\Models\MasterBarang;

use PDF;

class TrendBulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.trend-bulan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'jenisLaporan' => 'required|string|in:Pemasukan,Pengeluaran',
            'bulan' => 'required|date_format:Y-m',
        ]);

        // Ambil data dari request
        $jenisLaporan = $request->input('jenisLaporan');
        $bulan = $request->input('bulan');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));

        // Query data transaksi berdasarkan filter
        $transaksiQuery = MasterTransaksi::whereYear('TanggalTransaksi', $year)
            ->whereMonth('TanggalTransaksi', $month);

        if ($jenisLaporan === 'Pemasukan') {
            $transaksiQuery->where('TipeTransaksi', 'I'); // 'I' untuk transaksi masuk/pemasukan
        } else {
            $transaksiQuery->where('TipeTransaksi', 'O'); // 'O' untuk transaksi keluar/pengeluaran
        }

        $transaksiData = $transaksiQuery->get();

        $mstrBarang = MasterBarang::all();
        $data = [
            'jenisLaporan' => $jenisLaporan,
            'bulan' => $bulan,
            'transaksiData' => $transaksiData,
            'mstBarang' => $mstrBarang,
        ];

        // Misalkan kita menggunakan dompdf untuk membuat PDF
        $pdf = PDF::loadView('laporan.trend_report', $data)->setPaper('a4', 'landscape');
        $pdf->setPaper(array(0, 0, 841.89, 595.28), 'landscape');

        // Stream atau download PDF
        return $pdf->download('laporan_trend_' . strtolower($jenisLaporan) . '_' . $bulan . '.pdf');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
