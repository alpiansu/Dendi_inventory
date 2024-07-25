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
    <title>Surat Jalan</title>
</head>
<body>
    <div class="container">
          <div class="info">
            <div>
              <p>Nama Toko: {{ $data[0]->NAMA_TOKO }}</p>
            </div>
            <div>
              <p>Docno: {{ $data[0]->DOCNO }}</p>
              <p>Tanggal NPB: {{ $data[0]->TGL_NPB }}</p>
            </div>
          </div>
          <h1>Bukti Pengiriman Barang NPB : {{ $data[0]->NO_NPB }}</h1>
          <p>Tanggal Cetak: {{ $tglSkr }}</p>
          <table>
            <tr>
              <th>Barcode</th>
              <th>Nama Barang</th>
              <th>Qty SJ</th>
            </tr>
            @php
                $totalQtySJ = 0;
            @endphp
            @foreach($data as $item) 
            <tr>
                <td>{{ $item->BARCODE }}</td>
                <td>{{ $item->NAMA_BARANG }}</td>
                <td>{{ number_format($item->QTY_SJ, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalQtySJ += intVal($item->QTY_SJ);
            @endphp
            @endforeach
            <tr>
                <td colspan="2"><b>Total</b></td>
                <td>{{ number_format($totalQtySJ, 0, ',', '.') }}</td>
            </tr>
          </table>
          <div class="footer-info">
            <div class="small-info">
              <p><center>PIC NPB: <br />{{ $data[0]->PIC_NPB }}</center></p>
            </div>
          </div>
          <div class="line"></div>
        </div>
</body>
</html>
