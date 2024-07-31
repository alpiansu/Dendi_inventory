@extends('adminlte::page')

@section('title', 'Laporan Trend Penggunaan Barang')

@section('content_header')
    <h1>Laporan Trend Penggunaan Barang per Plant</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Form Filter Laporan
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

            <form action="{{ route('laporan.trend.plant.export') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="KodePlant">Plant</label>
                    <select class="form-control" id="KodePlant" name="KodePlant" required>
                        <option value="">Pilih Plant</option>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->KodePlant }}">{{ $plant->NamaPlant }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <input type="month" class="form-control" id="bulan" name="bulan" required>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Export Laporan</button>
                </div>
            </form>
        </div>
    </div>
@stop
