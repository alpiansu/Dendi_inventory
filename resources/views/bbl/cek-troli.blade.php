@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Cek Troli Per User Mobile Apps</div>
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

                    @if ($dataTroli->isEmpty())
                        <p>Belum ada data tersedia</p>
                    @else
                    
                        <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-master-barang">
                            <thead>
                                @foreach ($dataTroli->first()->getAttributes() as $key => $value)
                                    <th>{{ $key }}</th>
                                @endforeach
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($dataTroli as $data)
                                <tr>
                                    @foreach ($data->getAttributes() as $key => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    <td>
                                        @if($data->jml_barang)
                                            <a href="{{ route('bbl.report.troli.detail', $data->id_user)}}" class="btn btn-sm btn-warning">Detail</a>
                                        @endif
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