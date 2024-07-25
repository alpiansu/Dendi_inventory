<?php

namespace App\Imports;

use App\Models\MasterBarcode;
use App\Models\Npb;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class NpbImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $lastIdToko = null;
    private $lastDocno = null;
    private $idInsit = null;
    private $idToko = null;

    public function model(array $row)
    {
        $barcodeString = $row['barcode'];
        $barcodeInfo = MasterBarcode::where(function ($query) use ($barcodeString) {
            $query->where('barcode1', $barcodeString)
                ->orWhere('barcode2', $barcodeString)
                ->orWhere('barcode3', $barcodeString);
        })->first();

        if ($barcodeInfo) {
            //jagaan untuk mengambil id_insit jika docno yang diinput pernah diinput
            $idBarang = $barcodeInfo->id_barang;
            $ambilIdInsit = Npb::where('docno', $row['docno'])->max('id_insit');
            if ($ambilIdInsit) {
                $ambilIdToko = Npb::where('docno', $row['docno'])->max('id_toko');
                $this->idInsit = $ambilIdInsit;
                $this->idToko = $ambilIdToko;
            } else {
                $this->idToko = $row['id_toko'];
                // Jika id_toko atau docno berubah, atur ulang id_insit menjadi nilai maksimum yang sudah ada + 1
                if ($row['id_toko'] != $this->lastIdToko || $row['docno'] != $this->lastDocno) {
                    $this->idInsit = Npb::max('id_insit') + 1;
                }
            }

            // Update nilai terakhir dari id_toko dan docno
            $this->lastIdToko = $row['id_toko'];
            $this->lastDocno = $row['docno'];

            // Jika data belum ada, buat data baru
            Npb::updateOrInsert(
                [
                    'docno' => $row['docno'],
                    'id_barang' => $idBarang,
                ],
                [
                    'id_insit' => $this->idInsit,
                    'id_toko' => $this->idToko,
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                    'qty' => $row['qty'],
                    'harga_beli' => $row['harga_satuan'],
                    'gross_beli' => DB::raw('qty * harga_beli'),
                ]
            );
        }
    }
}
