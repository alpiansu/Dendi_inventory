@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Tambah Jenis Barcode Baru</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('master.barcode.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="kodeJenis">Kode Jenis</label>
                                <input type="text" class="form-control @error('kodeJenis') is-invalid @enderror" id="kodeJenis" name="kodeJenis" value="{{ old('kodeJenis') }}" required>
                                @error('kodeJenis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="JenisBarcode">Jenis Barcode</label>
                                <input type="text" class="form-control @error('JenisBarcode') is-invalid @enderror" id="JenisBarcode" name="JenisBarcode" value="{{ old('JenisBarcode') }}" required>
                                @error('JenisBarcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button class="btn btn-warning btnback">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
