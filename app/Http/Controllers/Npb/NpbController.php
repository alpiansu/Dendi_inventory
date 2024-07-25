<?php

namespace App\Http\Controllers\npb;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NpbImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

use App\Exports\ExportDataNPB;

use App\Models\Npb;
use App\Models\MasterBarang;
use App\Models\MasterToko;
use App\Models\HistoryPenerimaan;
use App\Models\RekapNpb;
use PDF;

use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class NpbController extends Controller
{
    public function importForm()
    {
        return view('npb.import');
    }

    public function importData(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx',
            ]);

            $dataToImport = $request->file('file');

            // Mendapatkan docno yang sudah ada di database
            $existingDocnos = Npb::pluck('docno')->toArray();

            // Validasi setiap baris data di dalam file Excel
            $rowIndex = 1; // Indeks baris dimulai dari 1
            $excelData = Excel::toArray([], $dataToImport);
            $data = $excelData[0]; // Ambil data dari baris pertama (sheet pertama)
            foreach ($data as $row) {
                $validator = validator($row, [
                    '0' => [
                        'required',
                        Rule::notIn($existingDocnos), // Pastikan docno tidak ada di database
                    ],
                    '1' => 'required',
                    '2' => 'required',
                    '3' => 'required',
                    '4' => 'required',
                ]);

                if ($validator->fails()) {
                    $validator->errors()->add('row_index', $rowIndex); // Tambahkan indeks baris ke pesan kesalahan
                    throw new ValidationException($validator);
                }

                $rowIndex++;
            }

            // Jika validasi berhasil, lanjutkan dengan import
            Excel::import(new NpbImport, $dataToImport);

            return redirect('/admin/npb/import')->with('success', 'Data berhasil diimport.');
        } catch (ValidationException $err) {
            $errors = $err->validator->errors()->get('row_index');
            $rowIndex = reset($errors);
            return redirect()->back()->withErrors(['row_index' => $rowIndex])->with('error', $err->getMessage());
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Proses Import dihentikan karena error: ' . $err->getMessage());
        }
    }

    public function buatForm(Request $request)
    {
        $tempData = Session::get('temp_npb', []);
        if ($tempData > 0) {
            $existingBarangIds = array_column($tempData, 'id_barang');
            $masterBarangList = MasterBarang::whereNotIn('id_barang', $existingBarangIds)->get();
        } else {
            $masterBarangList = MasterBarang::all();
        }

        $masterTokoList = MasterToko::all();

        return view('npb.buat', compact('masterBarangList', 'masterTokoList', 'tempData'));
    }

    public function prosesBuatForm(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date',
                'docno' => 'required',
                'id_barang' => 'required',
                'id_toko' => 'required',
                'qty' => 'required|numeric',
                'harga_beli' => 'required|numeric',
                'gross_beli' => 'required|numeric',
            ]);

            $tempData = Session::get('temp_npb', []);
            $existingIndex = $this->findExistingIndex($tempData, $request->all());

            // Validasi untuk memeriksa apakah docno sudah ada di database
            if (Npb::where('docno', $request->input('docno'))->exists()) {
                return redirect('/admin/npb/buat')->with('error', 'Docno ' . $request->input('docno') . ' sudah ada di database.');
            }

            if ($existingIndex !== false) {
                // Jika sudah ada, lakukan replace
                $tempData[$existingIndex]['qty'] = $request->input('qty');
                $tempData[$existingIndex]['harga_beli'] = $request->input('harga_beli');
                $tempData[$existingIndex]['gross_beli'] = $request->input('gross_beli');
            } else {
                // Jika belum ada, tambahkan data baru
                $item = $request->except('_token');

                // Ambil informasi lengkap tentang barang dari database berdasarkan ID
                $barang = MasterBarang::find($item['id_barang']);

                // Tambahkan informasi lengkap tentang barang ke dalam data
                $item['nama_barang'] = $barang->nama_barang;

                // Simpan data ke tempat penyimpanan sementara
                $tempData[] = $item;
            }

            Session::put('temp_npb', $tempData);

            return redirect()->route('npb.createForm')->with('success', 'Data berhasil ditambahkan ke tempat penyimpanan sementara.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Proses input dihentikan karena error: ' . $err->getMessage());
        }
    }

    public function hapusItem($index)
    {
        $tempData = Session::get('temp_npb', []);

        if (isset($tempData[$index])) {
            unset($tempData[$index]);
            Session::put('temp_npb', array_values($tempData));
        }

        return redirect('/admin/npb/buat')->with('success', 'Item berhasil dihapus dari data sementara.');
    }

    public function hapusSemua()
    {
        Session::forget('temp_npb');

        return redirect('/admin/npb/buat')->with('success', 'Semua data sementara berhasil dihapus.');
    }

    public function simpanData()
    {
        $tempData = Session::get('temp_npb', []);

        if (count($tempData) > 0) {
            // Ambil id_insit baru
            $idInsitBaru = Npb::max('id_insit') + 1;

            // Simpan transaksi
            foreach ($tempData as $item) {
                // Ambil informasi lengkap tentang barang dari database berdasarkan ID
                $barang = MasterBarang::find($item['id_barang']);

                // Tambahkan informasi lengkap tentang barang ke dalam data
                $item['nama_barang'] = $barang->nama_barang;

                // Simpan data ke database
                Npb::create([
                    'id_insit' => $idInsitBaru,
                    'tanggal' => $item['tanggal'],
                    'docno' => $item['docno'],
                    'id_barang' => $item['id_barang'],
                    'id_toko' => $item['id_toko'],
                    'qty' => $item['qty'],
                    'harga_beli' => $item['harga_beli'],
                    'gross_beli' => $item['gross_beli'],
                ]);
            }

            // Setelah data disimpan, bersihkan tempat penyimpanan sementara
            Session::forget('temp_npb');

            return redirect('/admin/npb/buat')->with('success', 'NPB dengan nomor ' . $idInsitBaru . ' berhasil di buat.');
        }

        return redirect('/admin/npb/buat')->with('warning', 'Tidak ada data untuk disimpan.');
    }

    public function history()
    {
        $dataHistory = RekapNpb::orderBy('WAKTU_BUAT', 'DESC')->get();
        return view('npb.history', compact('dataHistory'));
    }

    public function detailHistory($id)
    {
        $dataHistory = HistoryPenerimaan::where('DOCNO', $id)->orderBy('WAKTU_BUAT_NPB', 'DESC')->get();
        return view('npb.detailHistory', compact('dataHistory', 'id'));
    }

    public function resetFlagRecid($id)
    {
        try {
            Npb::where('id_insit', $id)->update([
                'recid' => '*'
            ]);

            return redirect()->route('npb.report')->with('success', 'Flag NPB berhasil di reset!');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Gagal update flag NPB! : ' . $th);
        }
    }

    public function exportSJToPDF($id)
    {
        try {
            $tglSkr = Carbon::now()->format('Y-m-d');
            $data = HistoryPenerimaan::where('docno', $id)->get();

            if (!$data->isEmpty()) {
                $namaPdf = $data[0]->NAMA_TOKO . " NPB " . $data[0]->DOCNO;
                $pdf = PDF::loadView('npb.sjNpb', compact('data', 'tglSkr'));
                return $pdf->download($namaPdf . '.pdf');
            } else {
                return redirect()->back()->with('error', 'Tidak ada data dengan docno ' . $id);
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal Download SJ NPB : ' . $err);
        }
    }

    public function exportSJPenerimaanToPdf($id)
    {
        try {
            $tglSkr = Carbon::now()->format('Y-m-d');
            $data = HistoryPenerimaan::where('docno', $id)->get();
            $namaPdf = "Tanda Terima NPB " . $data[0]->NAMA_TOKO . " " . $data[0]->DOCNO;
            // Load view ke dalam PDF
            $pdf = PDF::loadView('npb.sjPenerimaan', compact('data', 'tglSkr'));
            // Unduh atau tampilkan PDF
            return $pdf->download($namaPdf . '.pdf');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal Download SJ Penerimaan NPB : ' . $err);
        }
    }

    public function excelReport()
    {
        try {
            $tglSkr = Carbon::now()->format('Y-m-d');
            $filename = 'DataNpb' . $tglSkr . '.xlsx';
            return Excel::download(new ExportDataNPB(), $filename);
        } catch (\Exception $err) {
            return back()->withError($err->getMessage());
        }
    }

    private function findExistingIndex($tempData, $requestData)
    {
        foreach ($tempData as $index => $data) {
            if (
                $data['tanggal'] == $requestData['tanggal'] &&
                $data['docno'] == $requestData['docno'] &&
                $data['id_barang'] == $requestData['id_barang']
            ) {
                return $index;
            }
        }
        return false;
    }
}
