@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Input Data Barang dan Stock untuk SO</div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('so.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="kode_item" class="form-label">Kode Item</label>
                                <input type="text" class="form-control" id="kode_item" name="kode_item" required>
                            </div>
                            <div class="mb-3">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" class="form-control" id="barcode" name="barcode" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                                @error('qty')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
