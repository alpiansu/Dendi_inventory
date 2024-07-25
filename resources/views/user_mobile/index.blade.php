@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                    <table class="table table-bordered table-hover stripe order-column nowrap" id="tbl-list-mobileuser">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Addtime</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->nama_user }}</td>
                                    <td>{{ $user->addtime }}</td>
                                    <td>
                                        <a href="{{ route('user_mobile.delete', $user->id_user) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                                        <a href="{{ route('user_mobile.resetPassword', $user->id_user) }}" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mereset password user ini?')">Reset Password</a>
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