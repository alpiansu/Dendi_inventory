@extends('adminlte::page')

@section('title', 'Data Barang')

@section('content_header')
    <h1>Master Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Daftar Barang
        </div>
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

            <a href="{{ route('master.barang.create') }}" class="btn btn-primary mb-2">
                Input data baru
            </a>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                        <tr>
                            <td>{{ $barang->KodeBarang }}</td>
                            <td>{{ $barang->NamaItem }}</td>
                            <td>Rp {{ number_format($barang->Harga, 0, ',', '.') }}</td>
                            <td>{{ $barang->qty }}</td>
                            <td>
                                <a href="{{ route('master.barang.edit', $barang->KodeBarang) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('master.barang.destroy', $barang->KodeBarang) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-hapus-view" data-kode="{{ $barang->KodeBarang }}" data-nama="{{ $barang->NamaItem }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
