@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success mt-2" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @error('file')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                @error('row_index')
                    <div class="alert alert-danger mt-2" role="alert">
                        Error pada baris ke-{{ $message }}. Pastikan docno unik dan tidak ada di database.
                    </div>
                @enderror

                <div class="card mt-4">
                    <div class="card-header">Form Import NPB</div>

                    <div class="card-body">
                        <form action="{{ route('npb.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Pilih File Excel (.xlsx)</label>
                                <input type="file" name="file" class="form-control-file">
                                @error('file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>

                            <a href="{{ url('/master-format/master-format-import-npb.xlsx') }}" class="btn btn-success ml-2">
                                Download Master Template
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
