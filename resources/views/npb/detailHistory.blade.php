@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Detail NPB DOCNO {{ $id }}</div>
                <div class="card-body">
                    <a href="#" class="btn btn-warning ml-2 mb-2 btnback">
                        Kembali
                    </a>
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-history-npb">
                        <thead>
                            @foreach ($dataHistory->first()->getAttributes() as $key => $value)
                                <th>{{ $key }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach ($dataHistory as $data)
                            <tr>
                                @foreach ($data->getAttributes() as $key => $value)
                                    @if ($key == 'GROSS_BELI' || $key == 'HARGA_BELI')
                                        <td>Rp {{ number_format($value, 0, ',', '.') }}</td>
                                    @else
                                        <td>{{ $value }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
