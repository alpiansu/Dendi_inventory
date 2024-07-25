@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Input Data Toko</div>
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
                    <form action="{{ url('/admin/master/toko/create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama_toko">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control" required>
                            @error('nama_toko')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="initial_toko">Initial Toko</label>
                            <input type="text" name="initial_toko" class="form-control" required>
                            @error('initial_toko')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
