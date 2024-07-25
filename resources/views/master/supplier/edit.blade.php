@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Edit Data Supplier</div>
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
                    <form action="{{ route('master.supplier.update' . $toko->id_supp) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_supp">Nama Supplier</label>
                            <input type="text" name="nama_supp" class="form-control" value="{{ $toko->nama_supp }}" required>
                            @error('nama_supp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="initial_supp">Initial Suppler</label>
                            <input type="text" name="initial_supp" class="form-control" value="{{ $toko->initial_supp }}" required>
                            @error('initial_supp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
