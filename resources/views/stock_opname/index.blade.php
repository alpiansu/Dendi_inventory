@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Data Detail SO</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h6>ID SO : {{ $idSo ? $idSo->id_so : 'Tidak ada ID So yang aktif!' }} 
                        @if ($idSo)
                            <form action="{{ route('detail-so.updateSoStatus') }}" method="POST">
                                @csrf()
                                <input type="hidden" name="id_so" value="{{ $idSo->id_so }}" />
                                <button class="btn btn-info" id="btnSoSelesai">Selesaikan Stock Opname!</button>
                            </form>
                        @endif
                    </h6>
                    <table class="table table-bordered table-hover tbl-datatable stripe order-column nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Stock Awal</th>
                                <th scope="col">Qty Scan</th>
                                <th scope="col">Qty Adjust</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Waktu Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailSo as $item)
                                <tr>
                                    <td>{{ $item->barcode }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->stock_awal }}</td>
                                    <td>{{ $item->qty_scan }}</td>
                                    <td>{{ $item->qty_adjust }}</td>
                                    <td>{{ $item->nama_user }}</td>
                                    <td>{{ $item->waktu_scan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
