@extends('layouts.front.main')

@section('custom_css')
    <style>
        body::before{
            background: url('https://kingsgaming.us/img/backgrounds/main.jpg') no-repeat center;
            -webkit-filter: blur(5px);
            filter: blur(10px);
            opacity: 0.2;
        }
    </style>
@endsection
@section('title', 'Kingsgaming - Leaderboards')
@section('content')
    <div class="container">
        <div class="jumbotron d-flex align-items-center bg-transparent text-white">
            <div class="container">
                <h1 class="display-4 text-center text-uppercase">Kings Gaming</h1>
                <img src="https://kingsgaming.us/img/logo-full.svg" class="w-25 h-auto mx-auto justify-content-center d-flex flex-column pt-3 pb-3">
                <p class="text-center h4">Leaderboards of our top players!</p>

                <div class="table-responsive">
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