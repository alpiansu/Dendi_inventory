<?php
namespace App\Exports;

use App\Models\hasil_final;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class MasterDataExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($idSo)
    {
        $this->idSo = $idSo;
    }

    public function query()
    {
        return hasil_final::query()->select('kode_item', 'barcode', 'nama_item', 'jenis', 'satuan', 'merek', 'satuan_dasar', 'konversi_satuan_dasar', 
            'harga_pokok', 'harga_jual', 
            'stok', 'stok_minimum', 'tipe_item', 'menggunakan_serial', 'rak', 'kode_gudang_kantor', 'kode_supplier', 'keterangan')
            ->where('id_so', $this->idSo);;
    }

    public function headings(): array
    {
        // Sesuaikan dengan nama kolom yang ingin Anda eksport
        return [
            'kode_item', 'barcode', 'nama_item', 'jenis', 'satuan', 'merek', 'satuan_dasar', 'konversi_satuan_dasar', 
            'harga_pokok', 'harga_jual', 
            'stok', 'stok_minimum', 'tipe_item', 'menggunakan_serial', 'rak', 'kode_gudang_kantor', 'kode_supplier', 'keterangan'
        ];
    }
}
