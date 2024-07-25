@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Tambah Data Plant Baru</div>
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

                        <form action="{{ route('master.plant.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="KodePlant">Kode Plant</label>
                                <input type="text" class="form-control @error('KodePlant') is-invalid @enderror" id="KodePlant" name="KodePlant" value="{{ old('KodePlant') }}" required>
                                @error('KodePlant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NamaPlant">Nama Plant</label>
                                <input type="text" class="form-control @error('NamaPlant') is-invalid @enderror" id="NamaPlant" name="NamaPlant" value="{{ old('NamaPlant') }}" required>
                                @error('NamaPlant')
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
