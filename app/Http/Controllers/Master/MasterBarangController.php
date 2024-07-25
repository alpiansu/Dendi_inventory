<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Imports\MasterBarangImport;
use App\Models\MasterBarang;
use App\Models\MasterBarcode;
use App\Models\MasterJenisBarcode;
use App\Exports\ExportDataMasterBarangAll;

class MasterBarangController extends Controller
{
    public function importForm()
    {
        return view('master.barang.import');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx',
            ]);

            $file = $request->file('file');

            DB::beginTransaction();
            Excel::import(new MasterBarangImport, $file);
            DB::commit();

            return redirect('admin/master/barang/import')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $getmsg = $e->getmessage();
            return redirect('admin/master/barang/import')->with('error', 'Terjadi kesalahan. : ' . $getmsg . ' Silakan coba lagi.');
        }
    }

    public function excelReport()
    {
        try {
            $tglSkr = Carbon::now()->format('Y-m-d');
            $filename = 'Data Barang All - ' . $tglSkr . '.xlsx';
            return Excel::download(new ExportDataMasterBarangAll(), $filename);
        } catch (\Exception $err) {
            return back()->withError($err->getMessage());
        }
    }

    public function index()
    {
        $barangs = MasterBarang::all();
        return view('master.barang.index', compact('barangs'));
    }

    public function editForm($id)
    {
        $masterData = MasterBarang::findOrFail($id);
        $masterBarcodes = MasterBarcode::where('KodeBarang', $id)->get();
        $jenisBarcodes = MasterJenisBarcode::all();
        return view('master.barang.edit', compact('masterData', 'masterBarcodes', 'jenisBarcodes'));
    }

    public function updateData(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'KodeBarang' => 'required|string|max:50|exists:masterbarang,KodeBarang',
            'NamaItem' => 'required|string|max:50',
            'Harga' => 'required|numeric',
            'JenisBarcode' => 'required|array',
            'JenisBarcode.*' => 'required|string|exists:master_jenis_barcode,kodeJenis',
            'BarcodeBarang' => 'required|array',
            'BarcodeBarang.*' => 'required|string',
        ]);

        try {
            // Update data MasterBarang
            $barang = MasterBarang::findOrFail($id);
            $barang->update([
                'NamaItem' => $request->NamaItem,
                'Harga' => $request->Harga,
            ]);

            // Hapus semua barcodes terkait dengan KodeBarang ini
            MasterBarcode::where('KodeBarang', $id)->delete();

            // Tambah data barcode baru
            foreach ($request->JenisBarcode as $index => $kodeJenis) {
                $barcode = new MasterBarcode([
                    'KodeBarang' => $id,
                    'kodeJenis' => $kodeJenis,
                    'BarcodeBarang' => $request->BarcodeBarang[$index],
                ]);
                $barcode->save();
            }

            return redirect()->route('master.barang.index')->with('success', 'Barang berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengupdate barang: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $barang = MasterBarang::findOrFail($id);
            $barang->delete();

            return redirect()->route('master.barang.index')->with('success', 'Data barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data barang: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        $jenisBarcodes = MasterJenisBarcode::all();
        return view('master.barang.create', compact('jenisBarcodes'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'KodeBarang' => 'required|string|max:50|unique:masterbarang,KodeBarang',
            'NamaItem' => 'required|string|max:50',
            'Harga' => 'required|numeric',
            'JenisBarcode' => 'required|array',
            'JenisBarcode.*' => 'required|string|exists:master_jenis_barcode,kodeJenis',
            'BarcodeBarang' => 'required|array',
            'BarcodeBarang.*' => 'required|string',
        ]);

        try {
            // Membuat instance baru dari MasterBarang
            $barang = new MasterBarang([
                'KodeBarang' => $request->KodeBarang,
                'NamaItem' => $request->NamaItem,
                'Harga' => $request->Harga,
            ]);

            // Menyimpan data barang ke database
            $barang->save();

            $addid = Auth::id();
            // Menyimpan data barcode
            foreach ($request->JenisBarcode as $index => $kodeJenis) {
                $barcode = new MasterBarcode([
                    'KodeBarang' => $request->KodeBarang,
                    'kodeJenis' => $kodeJenis,
                    'BarcodeBarang' => $request->BarcodeBarang[$index],
                    'addid' => $addid,
                ]);
                $barcode->save();
            }

            return redirect()->route('master.barang.index')->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan barang: ' . $e->getMessage()]);
        }
    }
}
