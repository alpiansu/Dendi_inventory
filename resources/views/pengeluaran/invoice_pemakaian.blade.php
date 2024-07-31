<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Penerimaan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header-info p {
            margin: 5px 0;
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
        }
    </style>
</head>
<body>
    <h1>Invoice Penerimaan Barang</h1>
    
    <div class="header-info">
        <div>
            <p><strong>Document Number:</strong> {{ $docno }}</p>
        </div>
        <div>
            <p><strong>Pengirim:</strong> {{ $pengirim }}</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($barangDetails as $detail)
                @php
                    $barang = $dataBrg->firstWhere('KodeBarang', $detail['KodeBarang']);
                    $subtotal = $detail['Qty'] * $detail['Harga'];
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detail['KodeBarang'] }}</td>
                    <td>{{ $barang->NamaItem ?? 'Nama Tidak Ditemukan' }}</td>
                    <td>{{ number_format($detail['Qty'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail['Harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>