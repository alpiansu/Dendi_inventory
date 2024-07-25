@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">History SO</div>
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

                    <table class="table table-bordered table-hover stripe order-column nowrap" id="history-so-table">
                        <thead>
                            <tr>
                                <th scope="col">ID SO</th>
                                <th scope="col">Tanggal SO</th>
                                <th scope="col">Status</th>
                                <th scope="col">Mulai SO</th>
                                <th scope="col">Selesai SO</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masterSo as $data)
                                <tr>
                                    <td>{{ $data->id_so }}</td>
                                    <td>{{ $data->tanggal }}</td>
                                    <td>{{ $data->status ? 'Selesai' : 'Belum Selesai' }}</td>
                                    <td>{{ $data->mulai }}</td>
                                    <td>{{ $data->selesai }}</td>
                                    <td>
                                        <form action="{{ url('/admin/so/export/final') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="idSo" value="{{ $data->id_so }}" />
                                            <button type="submit" class="btn btn-success mb-2">Export Data Final</button>
                                        </form>

                                        <form action="{{ url('/admin/so/export/selisih') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="idSo" value="{{ $data->id_so }}" />
                                            <button type="submit" class="btn btn-warning">Export Data Selisih</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
