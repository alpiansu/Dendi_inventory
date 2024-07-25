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
                        <a href="{{ route('npb.report.excelReport') }}" class="btn btn-success ml-2 mb-2" style="width: 98%">
                            Export
                        </a>
                        <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-history-npb">
                            <thead>
                                @foreach ($dataHistory->first()->getAttributes() as $key => $value)
                                    <th>{{ $key }}</th>
                                @endforeach
                                <th>Action</th>
                                <th>Cetak</th>
                            </thead>
                            <tbody>
                                @foreach ($dataHistory as $data)
                                <tr>
                                    @foreach ($data->getAttributes() as $key => $value)
                                        @if ($key == 'GROSS_BELI')
                                            <td>Rp {{ number_format($value, 0, ',', '.') }}</td>
                                        @else
                                            <td>{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td>
                                        <a href="{{ route('npb.report.detail', $data->DOCNO)}}" class="btn btn-sm btn-warning">Detail</a>
                                        &nbsp;
                                        <form action="{{ route('npb.report.updflagnpb', $data->ID_INSIT)}}" method="post" style="display:inline;" >
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-reset-npb btn btn-sm btn-danger">Reset Flag Pengecekan</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('npb.report.exportsjpdf', $data->DOCNO) }}" class="btn btn-sm btn-info">Cetak SJ Pengiriman</a>
                                        &nbsp;
                                        <a href="{{ route('npb.report.exportSJTerimaToPdf', $data->DOCNO) }}" class="btn btn-sm btn-primary">Cetak Bukti Penerimaan</a>
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
