<?php

namespace App\Http\Controllers\StockOpname;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\MasterDataExport;
use App\Exports\SelisihDataExport;
use App\Models\DetailSo;

use App\Imports\ImportMasterBarangStock;

use App\Models\MasterProduk;
use App\Models\MasterSo;

class SOController extends Controller
{
    public function create()
    {
        return view('stock_opname.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_item' => 'required|string',
            'nama_barang' => 'required|string',
            'qty' => 'required|numeric',
        ], [
            'qty.numeric' => 'Qty harus berupa angka.',
        ]);

        try {
            $saveProduk = MasterProduk::create([
                'kode_item' => $request->kode_item,
                'barcode' => $request->barcode,
                'nama_barang' => $request->nama_barang,
                'qty' => $request->qty,
            ]);
            if ($saveProduk) {
                $dataMasterSo = MasterSo::where('status', '0')->first();
                if ($dataMasterSo) {
                    $idMasterSo = $dataMasterSo->id_so;
                    //insert juga ke detail SO
                    DetailSo::create([
                        'id_so' => $idMasterSo,
                        'barcode' => ($request->barcode != '' ? $request->barcode : $request->kode_item),
                        'com' => $request->qty,
                        'qty' => '0',
                    ]);
                }
            }
            return redirect()->route('so.create')->with('success', 'Data barang berhasil disimpan.');
        } catch (\Exception $e) {
            $getmsg = $e->getmessage();
            return redirect()->route('so.create')->with('error', 'Terjadi kesalahan. : ' . $getmsg . ' Silakan coba lagi.');
        }
    }

    public function index()
    {
        $detailSo = DB::select('SELECT barcode, nama_barang, stock_awal, qty_scan, qty_scan - stock_awal AS qty_adjust, id_initial_so, nama_user, waktu_scan FROM (
                SELECT dtl.barcode, prod.nama_barang, prod.qty AS stock_awal, dtl.qty AS qty_scan, init.id_initial_so, usr.nama_user, IF(usr.nama_user IS NOT NULL, dtl.updtime, NULL) AS waktu_scan 
                FROM detail_so dtl 
                    LEFT JOIN master_so mstr USING(id_so) 
                    LEFT JOIN master_produks prod ON dtl.barcode = prod.barcode
                    LEFT JOIN initial_so init ON dtl.id_initial_so = init.id_initial_so
                    LEFT JOIN master_users usr ON init.id_user = usr.id_user 
                        WHERE dtl.id_initial_so IS NOT NULL AND mstr.status = 0
                ) AS dtl_so;');
        $idSo = MasterSo::where('status', '0')->first();

        return view('stock_opname.index', compact('detailSo', 'idSo'));
    }

    public function updateSoStatus(Request $request)
    {
        try {
            $id = $request->id_so;
            $masterSo = MasterSo::find($id);

            if (!$masterSo) {
                return redirect()->route('detail-so.index')->with('error', 'data Master So dengan ID ' . $id . 'tidak ditemukan!');
            }
            $masterSo->selesai = Carbon::now()->format('Y-m-d');
            $masterSo->status = 1;
            $masterSo->save();

            return redirect()->route('detail-so.index')->with('success', 'Berhasil menyelesaikan Stock Opname');
        } catch (\Exception $e) {
            $getmsg = $e->getmessage();
            return redirect()->route('detail-so.index')->with('error', 'Terjadi kesalahan. : ' . $getmsg . ' Silakan coba lagi.');
        }
    }

    public function historyForm()
    {
        $masterSo = MasterSo::where('status', '1')
            ->orderBy('updtime', 'desc')
            ->get();
        return view('stock_opname.history', compact('masterSo'));
    }

    public function exportFinal(Request $request)
    {
        try {
            $idSo = $request->idSo;
            $filename = 'export_data_final_' . $idSo . '.xls';
            return Excel::download(new MasterDataExport($idSo), $filename);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function exportSelisih(Request $request)
    {
        try {
            $idSo = $request->idSo;
            $filename = 'export_data_selisih_' . $idSo . '.xls';
            return Excel::download(new SelisihDataExport($idSo), $filename);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function showFormImport()
    {
        return view('stock_opname.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        try {
            $cekSoAktif = MasterSo::where('status', '0')->get();
            if ($cekSoAktif->count() > 0) {
                return redirect()->route('import.form')->with('error', 'masih ada ' . $cekSoAktif->count() . ' id Stock Opname yang masih aktif, Proses Upload tidak bisa dilakukan ditengah proses stock opname!');
            } else {
                MasterProduk::truncate(); //sterilkan master produk terlebih dahulu
                $file = $request->file('file');
                Excel::import(new ImportMasterBarangStock(), $file);

                return redirect()->route('import.form')->with('success', 'File CSV berhasil diimport.');
            }
        } catch (\Exception $e) {
            return redirect()->route('import.form')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
