@extends('layouts.front.error')

@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url('img/bg.svg') }}") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
            /*background: #151719 url("https://kingsgaming.us/img/bg.svg");*/
        }
    </style>
@endsection
@section('title', 'Kingsgaming - Home')
@section('content')
    <div class="container-fluid pb-5">
        <div class="jumbotron d-flex flex-column bg-transparent text-white h-100">
            <div class="container mx-auto my-auto">
                <h1 class="display-4 text-center text-uppercase">Please stand by.</h1>
                <img src="{{ url('img/logo-full.svg') }}" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3">
                <p class="lead text-center" >We'll be right back...</p>
            </div>
        </div>
    </div>

@endsection
