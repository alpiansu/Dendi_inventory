@extends('adminlte::page')

@section('title', 'Transaksi Pemakaian Barang')

@section('content_header')
    <h1>Transaksi Pemakaian Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Form Transaksi Pemakaian Barang
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

        </div>
    </div>

    @push('js')
    
    @endpush
@stop