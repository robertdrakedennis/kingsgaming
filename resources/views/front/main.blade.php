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
                <h1 class="display-4 text-center text-uppercase">Kings Gaming</h1>
                <img src="{{ url('img/logo-full.svg') }}" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3" data-aos="fade-in" data-aos-delay="250" data-aos-easing="ease-in-out-cubic" id="">
                <p class="lead text-center"  data-aos-delay="350" data-aos-easing="ease-in-out-cubic">A server filled with custom content and awesome players!</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card-deck">
                    <div class="card bg-brand-darkest-grey text-white mb-5 h-auto w-65 border-0 mx-3 px-5"  data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
                        <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title text-center mt-auto"><i class="fab fa-discord"></i> {{str_limit($discordServerName, $limit = 35, $send="...")}}</h5>
                                <p class="card-text text-center h6 pb-2">{{$discordUsers}} online right now!</p>
                                <a href="{{route('discord')}}" class="btn btn-light justify-content-end mt-auto">Join our Discord!</a>
                        </div>
                    </div>
                    <div class="card bg-brand-darkest-grey text-white mb-5 h-auto w-65 border-0 mx-3 px-5"  data-aos="fade-up" data-aos-delay="350" data-aos-easing="ease-in-out-cubic">
                        <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title text-center mt-auto"><i class="fas fa-server"></i> {{str_limit($serverInfo['HostName'], $limit = 25, $send="...")}}</h5>
                                <div class="progress mb-3" style="height: 1.2rem;">
                                    <div class="progress-bar @if($calc <= 25) bg-success @elseif($calc >= 50) bg-warning @elseif($calc >= 75) bg-danger @else bg-success @endif" style="width: {{$calc}}%" role="progressbar" aria-valuenow="{{$serverInfo['Players']}}" aria-valuemin="0" aria-valuemax="{{$serverInfo['MaxPlayers']}}">{{$serverInfo['Players']}}/{{$serverInfo['MaxPlayers']}}</div></div>
                                <a href="{{route('server')}}" class="btn btn-light justify-content-end mt-auto">Connect now!</a>
                        </div>
                    </div>
                    <div class="card bg-brand-darkest-grey text-white mb-5 h-auto w-65 border-0 mx-3 px-5"  data-aos="fade-up" data-aos-delay="550" data-aos-easing="ease-in-out-cubic">
                        <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title text-center justify-content-center mt-auto"><i class="fab fa-steam"></i> Kingsgaming</h5>
                                <p class="card-text text-center h6">Total Members: {{ $memberCount }}</p>
                                <a href="{{route('steam')}}" class="btn btn-light justify-content-end mt-auto">Join our Community!</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
