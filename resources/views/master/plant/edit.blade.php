@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8"> <!-- Mengatur lebar form -->
                <div class="card mt-4">
                    <div class="card-header">Edit Data Plant</div>
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

                        <form action="{{ route('master.plant.update', $plant->KodePlant) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="KodePlant">Kode Plant</label>
                                <input type="text" class="form-control @error('KodePlant') is-invalid @enderror" id="KodePlant" name="KodePlant" value="{{ old('KodePlant', $plant->KodePlant) }}" required>
                                @error('KodePlant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NamaPlant">Nama Plant</label>
                                <input type="text" class="form-control @error('NamaPlant') is-invalid @enderror" id="NamaPlant" name="NamaPlant" value="{{ old('NamaPlant', $plant->NamaPlant) }}" required>
                                @error('NamaPlant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
