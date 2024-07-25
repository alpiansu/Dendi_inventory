<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\MasterBarangView;

class ExportDataMasterBarangAll implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MasterBarangView::all();
    }

    public function headings(): array
    {
        return [
            'ID_BARANG', 'KODE_BARANG', 'NAMA_BARANG', 'BARCODE1', 'BARCODE2', 'JENIS', 'SATUAN', 'MEREK', 'HARGA_POKOK', 'HARGA_JUAL', 'ADDTIME', 'UPDTIME'
        ];
    }
}
