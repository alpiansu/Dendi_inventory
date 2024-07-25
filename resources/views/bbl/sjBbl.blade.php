<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page{
            size: landscape;
        }

        body {
            font-family: Arial, sans-serif;
          }
          .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
          }
          h1 {
            text-align: center;
          }
          .info {
            display: flex;
            justify-content: space-between;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
          }
          th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
          }
          .small-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
          }
          .line {
            border-bottom: 1px solid #ddd;
            margin: 10px 0;
          }
          .footer-info {
            display: flex;
            justify-content: space-between;
          }
    </style>
    <title>Bukti Pembelian</title>
</head>
<body>
    <div class="container">
          <div class="info">
            <div>
              <p>Nama Supplier: {{ $data[0]->NAMA_SUPPLIER }}</p>
            </div>
            <div>
              <p>Tanggal PEMBELIAN: {{ $data[0]->TANGGAL }}</p>
            </div>
          </div>
          <h1>Bukti Pembelian Barang ID : {{ $data[0]->INVNO }}</h1>
          <p>Tanggal Cetak: {{ $tglSkr }}</p>
          <table class="nowrap">
            <tr>
              <th>Barcode</th>
              <th>Nama Barang</th>
              <th>Qty</th>
              <th>Gross</th>
            </tr>
            @php
                $totalQty = 0;
                $totalGross = 0;
            @endphp
            @foreach($data as $item) 
            <tr>
                <td>{{ $item->BARCODE }}</td>
                <td>{{ $item->NAMA_BARANG }}</td>
                <td>{{ number_format($item->QTY, 0, ',', '.') }}</td>
                <td>{{ 'Rp '.number_format($item->GROSS_BELI, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalQty += intVal($item->QTY);
                $totalGross += intVal($item->GROSS_BELI);
            @endphp
            @endforeach
            <tr>
                <td colspan="2"><b>Total</b></td>
                <td>{{ number_format($totalQty, 0, ',', '.') }}</td>
                <td>{{ 'Rp '.number_format($totalGross, 0, ',', '.') }}</td>
            </tr>
          </table>
          <div class="footer-info">
            <div class="small-info">
              <p><center>PIC : <br />{{ $data[0]->NAMA_USER }}</center></p>
            </div>
          </div>
          <div class="line"></div>
        </div>
</body>
</html>
