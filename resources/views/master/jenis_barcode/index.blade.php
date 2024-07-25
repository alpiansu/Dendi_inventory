@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Master Jenis Barcode</div>
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

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($masterData->isEmpty())
                            <p>Belum ada data tersedia</p>
                        @else
                            {{-- <a href="{{ route('master.alat.excelReportAll') }}" class="btn btn-success ml-2 mb-2" style="width: 98%">
                                Export
                            </a> --}}
                            <a href="{{ route('master.barcode.create') }}" class="btn btn-primary mb-2">
                                Input data baru
                            </a>
                            <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-master-alat">
                                <thead>
                                    <tr>
                                        <th>Kode Jenis</th>
                                        <th>Jenis Barcode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masterData as $data)
                                    <tr>
                                        <td>{{ $data->kodeJenis }}</td>
                                        <td>{{ $data->JenisBarcode }}</td>
                                        <td>
                                            <a href="{{ route('master.barcode.edit', $data->kodeJenis) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('master.barcode.destroy', $data->kodeJenis) }}" method="post" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-hapus-view" data-kode="{{ $data->kodeJenis }}" data-nama="{{ $data->JenisBarcode }}">Hapus</button>
                                            </form>
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
    </div>
@endsection
