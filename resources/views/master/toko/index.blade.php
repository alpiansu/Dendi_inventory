@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card mt-4">
            <div class="card-header">Data Toko</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="table table-hover tbl-datatable stripe order-column nowrap">
                    <thead>
                        <tr>
                            <th>ID Toko</th>
                            <th>Nama Toko</th>
                            <th>Initial Toko</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tokoList as $index => $toko)
                            <tr>
                                <td>{{ $toko->id_toko }}</td>
                                <td>{{ $toko->nama_toko }}</td>
                                <td>{{ $toko->initial_toko }}</td>
                                <td>
                                    <a href="{{ url('/admin/master/toko/edit/'. $toko->id_toko) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ url('/admin/master/toko/hapus/' . $toko->id_toko) }}" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-hapus-toko" data-kdtk="{{ $toko->id_toko }}" data-nama="{{ $toko->nama_toko }}">Hapus</button>
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
