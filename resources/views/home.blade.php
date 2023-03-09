@extends('layouts.app_')
@section('css')
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ url('adminlte3/plugins/wizard/css/montserrat-font.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/wizard/css/style.css') }}" />
    <meta name="robots" content="noindex, follow">

    <style>
        label {
            font-size: 12px !important;
        }

        .nav-item {
            font-size: 12px;
        }
    </style>
@endsection
@section('javascript')
@endsection
@section('content')
    <div class="card card-body">
        <h4 style="text-align: center">BIENVENIDO A SIMED</h4>
    </div>
@endsection
