@extends('layouts.front.main')

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
        <div class="jumbotron d-flex align-items-center bg-transparent text-white" data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
            <div class="container">
                <h1 class="display-4 text-center text-uppercase">404 Page Not Found...</h1>
                <img src="{{ url('img/logo-full.svg') }}" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3" data-aos="fade-in" data-aos-delay="250" data-aos-easing="ease-in-out-cubic" id="">
                <p class="lead text-center"  data-aos-delay="350" data-aos-easing="ease-in-out-cubic">If you think this is an error, please mention us in the discord!</p>
            </div>
        </div>
    </div>

@endsection
