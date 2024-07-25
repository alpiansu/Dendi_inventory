@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Master Configurasi</div>
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

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">RKey</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Updated Time</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tConsts as $tConst)
                                    <tr>
                                        <td>{{ $tConst->rkey }}</td>
                                        <td>{{ $tConst->desc }}</td>
                                        <td>{{ $tConst->status ? 'True' : 'False' }}</td>
                                        <td>{{ $tConst->updtime }}</td>
                                        <td>
                                            <form action="{{ route('const.updateStatus', $tConst->rkey) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm">Toggle Status</button>
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
    </div>
@endsection