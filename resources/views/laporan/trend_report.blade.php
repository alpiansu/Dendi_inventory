<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tren Bulanan</title>
    <style>
        @page { margin: 30px; }
        body { margin: 10px; }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Tren Bulanan</h1>
    <h2>{{ $jenisLaporan }} - {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</h2>
    
    <table>
        <thead>
            <tr>
                <th>Transaksi ID</th>
                <th>Tanggal</th>
                <th>Dokumen No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($transaksiData as $transaksi)
                @php
                    $barang = $mstBarang->firstWhere('KodeBarang', $transaksi['KodeBarang']);
                    $subtotal = $transaksi->Qty * $transaksi->Harga;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $transaksi->TransaksiID }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->TanggalTransaksi)->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->docno }}</td>
                    <td>{{ $transaksi->KodeBarang }}</td>
                    <td>{{ $barang->NamaItem ?? 'Nama Tidak Ditemukan' }}</td>
                    <td class="text-right">{{ number_format($transaksi->Qty, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->Harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="7" class="text-right">Total:</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
