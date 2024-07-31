@extends('adminlte::page')

@section('title', 'Laporan Trend Pengeluaran & Pemasukan')

@section('content_header')
    <h1>Laporan Trend Pengeluaran & Pemasukan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Pilih Filter Laporan
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

            <form action="{{ route('laporan.trend.export') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jenisLaporan">Jenis Laporan</label>
                    <select class="form-control" id="jenisLaporan" name="jenisLaporan" required>
                        <option value="">Pilih Jenis Laporan</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <input type="month" class="form-control" id="bulan" name="bulan" required>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Export Laporan</button>
                </div>
            </form>
        </div>
    </div>
@stop
