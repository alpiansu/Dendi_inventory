<?php
namespace App\Exports;

use App\Models\cetak_selisih;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class SelisihDataExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($idSo)
    {
        $this->idSo = $idSo;
    }

    public function query()
    {
        return cetak_selisih::query()->select('kode_item', 'barcode', 'nama_item', 'stok_awal', 'stok', 'selisih')->where('id_so', $this->idSo);
    }

    public function headings(): array
    {
        return [
            'kode_item', 'barcode', 'nama_item', 'stok_awal', 'stok', 'selisih'
        ];
    }
}
