@extends('layouts.front.main')

@section('custom_css')
    <style>
        body{
            background: #23272a;
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
                <p class="text-center h4" data-aos="fade-in" data-aos-delay="650" data-aos-easing="ease-in-out-cubic">Leaderboards of our top players!</p>

                <div class="table-responsive" data-aos="fade-up" data-aos-delay="150" data-aos-easing="ease-in-out-cubic">
                    <table class="table table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">ID</th>
                            <th scope="col">$</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($players as $player)
                            <tr>
                                <td>{{$player->rpname}}</td>
                                <td>{{$player->uid}}</td>
                                <td>{{number_format($player->wallet)}}</td>
                            </tr>
                        @endforeach
                        {{ $players->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection