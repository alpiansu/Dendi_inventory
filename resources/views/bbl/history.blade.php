@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">History Penerimaan</div>
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

                    @if ($dataHistory->isEmpty())
                        <p>Belum ada data tersedia</p>
                    @else
                    
                        <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-master-barang">
                            <thead>
                                @foreach ($dataHistory->first()->getAttributes() as $key => $value)
                                    <th>{{ $key }}</th>
                                @endforeach
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($dataHistory as $data)
                                <tr>
                                    @foreach ($data->getAttributes() as $key => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{ route('bbl.report.detail', $data->INVNO)}}" class="btn btn-sm btn-warning">Detail</a>
                                        <a href="{{ route('bbl.report.exportsjpdf', $data->INVNO) }}" class="btn btn-sm btn-info">Cetak SJ Pengiriman</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
