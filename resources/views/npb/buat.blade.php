@extends('adminlte::page')
{{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}

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
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card mt-4">
                    <div class="card-header">Form Input NPB</div>

                    <div class="card-body">
                        <form action="{{ url('/admin/npb/buat') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="docno">Docno</label>
                                @if(count($tempData) > 0)
                                    <input type="text" name="docno" class="form-control" value="{{ $tempData[0]['docno'] }}" readonly>
                                @else
                                    <input type="text" name="docno" class="form-control" value="{{ old('docno') }}" required>
                                @endif
                                @error('docno')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="id_barang">Pilih Toko</label>
                                @if(count($tempData) > 0)
                                    <input type="hidden" name="id_toko" value="{{ $tempData[0]['id_toko'] }}" />
                                @endif
                                <select class="form-control select2-basic" id="id_toko" name="id_toko" style="width: 100%;" {{ (count($tempData) > 0 ? 'disabled' : '')  }} >

                                    @foreach($masterTokoList as $masterToko)
                                        <option value="{{ $masterToko->id_toko }}" {{ (count($tempData) > 0 && $tempData[0]['id_toko'] == $masterToko->id_toko ? 'selected' : '')  }}>
                                            {{ $masterToko->id_toko }} - {{ $masterToko->nama_toko }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_toko')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="id_barang">Pilih Barang</label>
                                <select class="form-control select2-basic" id="id_barang" name="id_barang" style="width: 100%;">
                                    @foreach($masterBarangList as $masterBarang)
                                        <option value="{{ $masterBarang->id_barang }}">
                                            {{ $masterBarang->kode_barang }} - {{ $masterBarang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" id="qty_beli" class="form-control" required>
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                                @error('harga_beli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gross_beli">Gross Beli</label>
                                <input type="number" name="gross_beli" id="gross_beli" class="form-control" readonly required>
                                @error('gross_beli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Tambahkan ke Tempat Penyimpanan</button>
                        </form>

                        <hr>

                        @if(count($tempData) > 0)
                            <h3>Data Barang Yang Akan Di Buatkan NPB</h3>
                            <form action="{{ url('/admin/npb/hapus-semua') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Hapus Semua Data</button>
                            </form>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Docno</th>
                                        <th>Barang</th>
                                        <th>Qty</th>
                                        <th>Harga Beli</th>
                                        <th>Gross Beli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tempData as $index => $data)
                                        <tr>
                                            <td>{{ $data['tanggal'] }}</td>
                                            <td>{{ $data['docno'] }}</td>
                                            <td>{{ $data['nama_barang'] }}</td>
                                            <td>{{ $data['qty'] }}</td>
                                            <td>{{ $data['harga_beli'] }}</td>
                                            <td>{{ $data['gross_beli'] }}</td>
                                            <td>
                                                <form action="{{ url('/admin/npb/hapus-item/' . $index) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus Item</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form action="{{ url('/admin/npb/simpan') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Buat NPB</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2-container--default .select2-selection--single{
            padding: 3px !important;
        }
    </style>
@endsection
