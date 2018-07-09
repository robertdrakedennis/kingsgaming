@extends('layouts.front.main')
@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url('img/bg.svg') }}") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
        }
    </style>
@endsection
@section('title', 'Kingsgaming - Leaderboards')
@section('content')
    <div class="container">
        <div class="jumbotron d-flex align-items-center bg-transparent text-white">
            <div class="container">
                <h1 class="display-4 text-center text-uppercase" data-aos="fade-in" data-aos-delay="250" data-aos-easing="ease-in-out-cubic">Kings Gaming</h1>
                <img src="https://kingsgaming.us/img/logo-full.svg" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3" data-aos="fade-in" data-aos-delay="450" data-aos-easing="ease-in-out-cubic">
                <p class="text-center h4" data-aos="fade-in" data-aos-delay="650" data-aos-easing="ease-in-out-cubic">Our current staff team!</p>

                <div class="table-responsive" data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
                    <table class="table bg-brand-darkest-grey text-white border-0 table-borderless table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">ID</th>
                            <th scope="col">Rank</th>
                            <th scope="col">Last Played</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($staff as $player)
                            <tr>
                                <td>{{$player->name}}</td>
                                <td>{{$player->steam_id}}</td>
                                <td>{{$player->rank}}</td>
                                <td>{{\Carbon\Carbon::createFromTimestamp($player->last_played)->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                        {{ $staff->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection