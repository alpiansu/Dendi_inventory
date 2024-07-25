@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Upload Data Stock Barang</div>

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

                        <form action="{{ route('import.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="file">Pilih file CSV:</label>
                                <input type="file" class="form-control" name="file" id="file" accept=".csv" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection