@extends('layouts.front.main')

@section('custom_css')
    <style>
        body::before{
            background: url('img/backgrounds/main.jpg') no-repeat center;
            -webkit-filter: blur(5px); /* Safari */
            filter: blur(10px);
            opacity: 0.2;
        }
    </style>
@endsection
@section('title', 'Kingsgaming')

@section('content')
    <div class="container">
        <div class="jumbotron d-flex align-items-center bg-transparent text-white" data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
            <div class="container">
                <h1 class="display-4 text-center text-uppercase">Kings Gaming</h1>
                <img src="img/logo-full.svg" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3" data-aos="fade-in" data-aos-delay="250" data-aos-easing="ease-in-out-cubic">
                <p class="lead text-center"  data-aos-delay="350" data-aos-easing="ease-in-out-cubic">A server filled with custom content and awesome players!</p>
            </div>
        </div>
    </div>


    <div class="container-fluid pb-5">
        <div class="row">
            <div class="card-deck mx-auto">
                    <div class="card bg-dark text-white mb-5 h-auto w-65 mx-2 border-0"  data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
                        <img class="card-img" src="img/backgrounds/discord.png" alt="Card image">
                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-center">
                            <h5 class="card-title text-center mt-auto">Discord: {{$discordServerName}}</h5>
                            <p class="card-text text-center h6 pb-2">{{$discordUsers}} online right now!</p>
                            <a href="{{route('discord')}}" class="btn btn-outline-light ustify-content-end mt-auto">Join our Discord!</a>
                        </div>
                    </div>
                    <div class="card bg-dark text-white mb-5 h-auto w-65  mx-2 border-0"  data-aos="fade-up" data-aos-delay="350" data-aos-easing="ease-in-out-cubic">
                        <img class="card-img" src="img/backgrounds/server.jpg"  alt="Card image" >
                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-center" style="background: rgba(5,5,5,0.8);">
                            <h5 class="card-title text-center mt-auto">Server: {{$serverInfo['HostName']}}</h5>
                            <p class="card-text text-center h6 pb-2">Gamemode: DarkRP</p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated @if($calc < 25) bg-success @elseif($calc > 50) bg-warning @elseif($calc > 75) bg-danger @else bg-primary @endif" style="width: {{$calc}}%" role="progressbar" aria-valuenow="{{$serverInfo['Players']}}" aria-valuemin="0" aria-valuemax="{{$serverInfo['MaxPlayers']}}"></div>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Launch demo modal
                            </button>
                            <p class="card-text text-center text-muted text-uppercase pt-2">{{$serverInfo['Players']}}/{{$serverInfo['MaxPlayers']}} Players Online</p>
                            <a href="{{route('server')}}" class="btn btn-outline-light ustify-content-end mt-auto">Connect now!</a>
                        </div>
                    </div>
                    <div class="card bg-dark text-white mb-5 h-auto w-65  mx-2 border-0"  data-aos="fade-up" data-aos-delay="550" data-aos-easing="ease-in-out-cubic">
                        <img class="card-img" src="img/backgrounds/group.jpg"  alt="Card image">
                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-center" style="background: rgba(5,5,5,0.8);">
                            <h5 class="card-title text-center justify-content-center mt-auto">Steamgroup: Kingsgaming</h5>
                            <p class="card-text text-center h6">Total Members: {{ $memberCount }}</p>
                            <a href="{{route('steam')}}" class="btn btn-outline-light justify-content-end mt-auto">Join our Community!</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
