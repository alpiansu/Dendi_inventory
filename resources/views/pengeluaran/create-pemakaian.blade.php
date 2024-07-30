@extends('adminlte::page')

@section('title', 'Transaksi Pemakaian Barang')

@section('content_header')
    <h1>Transaksi Pemakaian Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Form Transaksi Pemakaian Barang
        </div>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.penerimaan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="transaksiId">Transaksi ID</label>
                    <input type="text" class="form-control" id="transaksiId" name="transaksiId" readonly>
                </div>
                <div class="form-group">
                    <label for="docno">Document Number</label>
                    <input type="text" class="form-control" id="docno" name="docno" value="{{ old('docno') }}" required>
                </div>
                <div class="form-group">
                    <label for="pengirim">Pengirim</label>
                    <input type="text" class="form-control" id="pengirim" name="pengirim" value="{{ old('pengirim') }}" required>
                </div>

                <!-- Dynamic fields for multiple KodeBarang -->
                <div id="barang-fields">
                    <div class="barang-field">
                        <div class="form-group">
                            <label for="KodeBarang_0">Kode Barang</label>
                            <select class="form-control kode-barang" id="KodeBarang_0" name="KodeBarang[]" required>
                                <option value="">Pilih Kode Barang</option>
                                @foreach ($masterBarangs as $barang)
                                    <option value="{{ $barang->KodeBarang }}">{{ $barang->KodeBarang }} - {{ $barang->NamaItem }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Qty_0">Qty</label>
                            <input type="number" class="form-control" id="Qty_0" name="Qty[]" value="{{ old('Qty.0') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="Harga_0">Harga</label>
                            <input type="number" step="0.01" class="form-control harga" id="Harga_0" name="Harga[]" readonly>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm btn-remove">Hapus Barang</button>
                    </div>
                </div>

                <button type="button" class="btn btn-success btn-sm mt-2 mb-2" id="btn-add-barang">Tambah Barang</button>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            // Load Transaksi ID saat halaman dimuat
            $.ajax({
                url: '/admin/get-transaksi-id/O',
                type: 'GET',
                success: function(data) {
                    $('#transaksiId').val(data.transaksiId);
                },
                error: function(error) {
                    console.log('Error fetching TransaksiID:', error);
                }
            });
        });
    </script>
    @endpush
@stop