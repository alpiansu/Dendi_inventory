@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Master Plant</div>
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
                    
                    <a href="{{ route('master.plant.create') }}" class="btn btn-primary mb-2">
                        Input data baru
                    </a>
                    @if ($masterData->isEmpty())
                        <p>Belum ada data tersedia</p>
                    @else
                        {{-- <a href="{{ route('master.alat.excelReportAll') }}" class="btn btn-success ml-2 mb-2" style="width: 98%">
                            Export
                        </a> --}}
                        <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-master-plant">
                            <thead>
                                <tr>
                                    <th>Kode Plant</th>
                                    <th>Nama Plant</th>
                                    <th>Ditambahkan Oleh</th>
                                    <th>Waktu Ditambahkan</th>
                                    <th>Diupdate Oleh</th>
                                    <th>Waktu Diupdate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masterData as $data)
                                <tr>
                                    <td>{{ $data->KodePlant }}</td>
                                    <td>{{ $data->NamaPlant }}</td>
                                    <td>{{ $data->addid }}</td>
                                    <td>{{ $data->addtime }}</td>
                                    <td>{{ $data->updid }}</td>
                                    <td>{{ $data->updtime }}</td>
                                    <td>
                                        <a href="{{ route('master.plant.edit', $data->KodePlant) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('master.plant.destroy', $data->KodePlant) }}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-hapus-view" data-kode="{{ $data->KodePlant }}" data-nama="{{ $data->NamaPlant }}">Hapus</button>
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
@endsection
