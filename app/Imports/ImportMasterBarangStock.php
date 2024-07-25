<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;

use App\Models\MasterProduk;

class ImportMasterBarangStock implements ToModel, WithHeadingRow, WithChunkReading
{
    use Importable;

    public function model(array $row)
    {
        $hasNonSpaceValues = !empty(trim($row['kode_item'])) && !empty(trim($row['nama_item']));
        
        if ($hasNonSpaceValues) {
            return new MasterProduk([
                'kode_item' => $row['kode_item'] ?? '',
                'barcode' => $row['kode_barcode'] ?? '',
                'nama_barang' => $row['nama_item'] ?? '',
                'qty' => $row['stok'] ?? 0,
            ]);
        }

    }
    
    public function headingRow(): int
    {
        return 8;
    }

    public function rules(): array
    {
        return [
            'kode_item' => ['required', 'string'],
            'nama_item' => ['required', 'string'],
            'qty' => ['required', 'numeric'],
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
