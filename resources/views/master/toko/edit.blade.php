@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Edit Data Toko</div>
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
                    <form action="{{ url('/admin/master/toko/edit/' . $toko->id_toko) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_toko">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control" value="{{ $toko->nama_toko }}" required>
                            @error('nama_toko')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="initial_toko">Initial Toko</label>
                            <input type="text" name="initial_toko" class="form-control" value="{{ $toko->initial_toko }}" required>
                            @error('initial_toko')
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
