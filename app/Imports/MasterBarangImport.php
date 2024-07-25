<?php

namespace App\Imports;

use App\Models\MasterBarangForImport;
use App\Models\MasterBarcode;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class MasterBarangImport implements ToModel, WithHeadingRow, WithChunkReading, WithMultipleSheets
{
    public function model(array $row)
    {
        // Proses insert ke model MasterBarang
        $masterBarang = MasterBarangForImport::updateOrInsert(
            [
                'kode_barang' => $row['kode_item'],
            ],
            [
                'nama_barang' => $row['nama_item'],
                'jenis' => $row['jenis'],
                'satuan' => $row['satuan'],
                'merek' => $row['merek'],
                'satuan_dasar' => $row['satuan_dasar'],
                'konversi_satuan_dasar' => $row['konversi_satuan_dasar'],
                'harga_pokok' => $row['harga_pokok'],
                'harga_jual' => $row['harga_jual'],
                'stok_minimum' => $row['stok_minimum'],
                'tipe_item' => $row['tipe_item'],
                'menggunakan_serial' => $row['menggunakan_serial'],
                'rak' => $row['rak'],
                'kode_gudang_kantor' => $row['kode_gudang_kantor'],
                'kode_supplier' => $row['kode_supplier'],
                'keterangan' => $row['keterangan'],
            ]
        );

        $reOpenBarang = MasterBarangForImport::where('kode_barang', $row['kode_item'])->max('id_barang');

        // Proses insert ke model MasterBarcode
        MasterBarcode::updateOrInsert(
            [
                'id_barang' => $reOpenBarang,
            ],
            [
                'barcode1' => $row['barcode'],
            ]
        );
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
