@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Import Master Barang</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ url('/admin/master/barang/import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Pilih File Excel (xlsx atau xls)</label>
                                <input type="file" name="file" id="file" class="form-control-file" accept=".xlsx, .xls" required>
                                @error('file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Import Master Barang</button>

                            <a href="{{ url('/master-format/master-format-barang.xlsx') }}" class="btn btn-success ml-2">
                                Download Master Template
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection