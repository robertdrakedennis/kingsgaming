@extends('layouts.front.main')

@section('custom_css')
    <style>
        body::before{
            background: url('https://pre00.deviantart.net/fbb3/th/pre/f/2015/248/3/0/supression_by_sidezeo-d98i21w.png') no-repeat center;
            -webkit-filter: blur(5px); /* Safari */
            filter: blur(10px);
            opacity: 0.2;
        }
    </style>
@endsection
@section('title', 'Kingsgaming')

@section('content')
<div class="container">
    <div class="jumbotron d-flex align-items-center bg-transparent text-white">
        <div class="container">
            <h1 class="display-4 text-center text-uppercase">Kings Gaming</h1>
            <img src="img/logo-full.svg" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3">
            <p class="lead text-center">A server filled with custom content and awesome players!</p>
            <p class="text-center">Click on the banner to join our server!</p>
        </div>
    </div>
</div>


            <div class="container-fluid pb-5">
<div class="row">
    <div class="card-deck mx-auto">
        <div class="card bg-dark text-white mb-5 h-auto w-65 mx-2 border-0">
            <img class="card-img" src="https://i.imgur.com/eS4IxK3.png" alt="Card image">
            <div class="card-img-overlay h-100 d-flex flex-column justify-content-center">
                <h5 class="card-title text-center">Discord: {{$discord_svname}}</h5>
                <p class="card-text text-center h6 pb-2">{{$discord_users}} online right now!</p>
            </div>
        </div>
        <div class="card bg-dark text-white mb-5 h-auto w-65  mx-2 border-0">
            <img class="card-img" src="https://edge.alluremedia.com.au/m/k/2014/04/hl2-2.jpg"  alt="Card image">
            <div class="card-img-overlay h-100 d-flex flex-column justify-content-center" style="background: rgba(5,5,5,0.8);">
                <h5 class="card-title text-center">Server: Kingsgaming</h5>
                <p class="card-text text-center h6 pb-2">Gamemode: DarkRP</p>
                <div class="progress">
                    <div class="progress-bar" style="width: {{$Info['Players']}}%" role="progressbar" aria-valuenow="{{$Info['Players']}}" aria-valuemin="0" aria-valuemax="{{$Info['MaxPlayers']}}"></div>
                </div>
                <p class="card-text text-center text-muted text-uppercase pt-2">{{$Info['Players']}}/{{$Info['MaxPlayers']}} Players Online</p>
            </div>
        </div>
        <div class="card bg-dark text-white mb-5 h-auto w-65  mx-2 border-0">
            <img class="card-img" src="https://pre00.deviantart.net/ade4/th/pre/f/2015/219/f/2/lockdown_by_sidezeo-d94mwv5.png"  alt="Card image">
            <div class="card-img-overlay h-100 d-flex flex-column justify-content-center" style="background: rgba(5,5,5,0.8);">
                <h5 class="card-title text-center">Steamgroup: Kingsgaming</h5>
                <p class="card-text text-center h6 pb-2">Total Members: {{ $memberCount }}</p>

            </div>
        </div>
    </div>
</div>
        </div>

@endsection