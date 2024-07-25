@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Master Alat</div>
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
                    <a href="{{ route('master.alat.create') }}" class="btn btn-primary mb-2">
                        Input data baru
                    </a>
                    @if ($masterData->isEmpty())
                        <p>Belum ada data tersedia</p>
                    @else
                        {{-- <a href="{{ route('master.alat.excelReportAll') }}" class="btn btn-success ml-2 mb-2" style="width: 98%">
                            Export
                        </a> --}}
                        <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-master-alat">
                            <thead>
                                <tr>
                                    <th>Kode Alat</th>
                                    <th>Nama Alat</th>
                                    <th>Plant</th>
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
                                    <td>{{ $data->KodeAlat }}</td>
                                    <td>{{ $data->NamaAlat }}</td>
                                    <td>{{ $data->NamaPlant }}</td>
                                    <td>{{ $data->addid }}</td>
                                    <td>{{ $data->addtime }}</td>
                                    <td>{{ $data->updid }}</td>
                                    <td>{{ $data->updtime }}</td>
                                    <td>
                                        <a href="{{ route('master.alat.edit', $data->KodeAlat) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('master.alat.destroy', $data->KodeAlat) }}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-hapus-view" data-kode="{{ $data->KodeAlat }}" data-nama="{{ $data->NamaAlat }}">Hapus</button>
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
