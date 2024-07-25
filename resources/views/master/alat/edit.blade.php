@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8"> <!-- Mengatur lebar form -->
                <div class="card mt-4">
                    <div class="card-header">Edit Data Alat</div>
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

                        <form action="{{ route('master.alat.update', $alat->KodeAlat) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="KodeAlat">Kode Alat</label>
                                <input type="text" class="form-control @error('KodeAlat') is-invalid @enderror" id="KodeAlat" name="KodeAlat" value="{{ old('KodeAlat', $alat->KodeAlat) }}" required>
                                @error('KodeAlat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NamaAlat">Nama Alat</label>
                                <input type="text" class="form-control @error('NamaAlat') is-invalid @enderror" id="NamaAlat" name="NamaAlat" value="{{ old('NamaAlat', $alat->NamaAlat) }}" required>
                                @error('NamaAlat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="KodePlant">Plant</label>
                                <select class="form-control @error('KodePlant') is-invalid @enderror" name="KodePlant">
                                    @foreach ($masterPlant as $plant)
                                        <option value="{{ $plant->KodePlant }}" {{ $plant->KodePlant == $alat->KodePlant ? 'selected' : '' }}>{{ $plant->NamaPlant }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button class="btn btn-warning btnback">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
