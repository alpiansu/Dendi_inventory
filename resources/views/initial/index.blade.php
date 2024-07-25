@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mt-4">
                <div class="card-header">Data Initial</div>
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
                    
                    <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-so-initial">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Username</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Status</th>
                                <th scope="col">Addtime</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($initials as $initial)
                                <tr>
                                    <td>{{ $initial->tanggal }}</td>
                                    <td>{{ $initial->username }}</td>
                                    <td>{{ $initial->nama_user }}</td>
                                    <td>{{ $initial->status ? 'True' : 'False' }}</td>
                                    <td>{{ $initial->addtime }}</td>
                                    <td>
                                        <form action="{{ route('initial.updateStatus', $initial->id_initial_so) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Toggle Status</button>
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
