@extends('adminlte::page', ['iFrameEnabled' => true])

@section('title', 'Dashboard Inventory')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop