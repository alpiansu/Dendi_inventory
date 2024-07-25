@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card mt-4">
            <div class="card-header">Data Supplier</div>
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
                <table class="table table-hover tbl-datatable table-bordered stripe order-column nowrap">
                    <thead>
                        <tr>
                            <th>ID Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Initial Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tokoList as $index => $toko)
                            <tr>
                                <td>{{ $toko->id_supp }}</td>
                                <td>{{ $toko->nama_supp }}</td>
                                <td>{{ $toko->initial_supp }}</td>
                                <td>
                                    <a href="{{ url('/admin/master/supplier/edit/'. $toko->id_supp) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ url('/admin/master/supplier/hapus/' . $toko->id_supp) }}" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-hapus-supp" data-kdtk="{{ $toko->id_supp }}" data-nama="{{ $toko->nama_supp }}">Hapus</button>
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
