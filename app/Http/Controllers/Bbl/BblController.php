<?php

namespace App\Http\Controllers\Bbl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HistoryPembelian;
use App\Models\RekapTroli;
use App\Models\CekTroli;
use App\Models\RekapPembelianView;
use Illuminate\Support\Carbon;
use PDF;

class BblController extends Controller
{
    public function historyPembelianForm()
    {
        $dataHistory = RekapPembelianView::orderBy('WAKTU_SIMPAN', 'DESC')->get();
        return view('bbl.history', compact('dataHistory'));
    }

    public function detailHistory($id)
    {
        $dataHistory = HistoryPembelian::where('INVNO', $id)->get();
        return view('bbl.detailHistory', compact('dataHistory', 'id'));
    }

    public function cekTroliForm()
    {
        $dataTroli = RekapTroli::all();
        return view('bbl.cek-troli', compact('dataTroli'));
    }

    public function detailTroli($id_user)
    {
        $dataTroli = CekTroli::where('id_user', $id_user)->get();
        return view('bbl.cek-troli', compact('dataTroli'));
    }

    public function exportSJToPDF($id)
    {
        try {
            $tglSkr = Carbon::now()->format('Y-m-d');
            $data = HistoryPembelian::where('INVNO', $id)->get();

            if (!$data->isEmpty()) {
                $namaPdf = $data[0]->NAMA_SUPPLIER . " Pembelian " . $data[0]->INVNO;
                $pdf = PDF::loadView('bbl.sjBbl', compact('data', 'tglSkr'));
                return $pdf->download($namaPdf . '.pdf');
            } else {
                return redirect()->back()->with('error', 'Tidak ada data dengan docno ' . $id);
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal Download Bukti Pembelian : ' . $err);
        }
    }
}
