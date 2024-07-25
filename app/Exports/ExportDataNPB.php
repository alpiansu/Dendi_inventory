<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\HistoryPenerimaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDataNPB implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return HistoryPenerimaan::all();
    }

    public function headings(): array
    {
        return [
            'ID_TOKO', 'NAMA_TOKO', 'KET', 'NO_NPB', 'DOCNO', 'TANGGAL_NPB', 'ID_BARANG', 'NAMA_BARANG', 'BARCODE', 'HARGA_BELI', 'GROSS_BELI', 'QTY_SJ', 'QTY_INPUT', 'PIC_NPB', 'WAKTU_BUAT_NPB', 'PIC_SCAN', 'WAKTU_SCAN'
        ];
    }
}
