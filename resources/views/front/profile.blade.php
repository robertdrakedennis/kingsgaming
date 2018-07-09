@extends('layouts.front.main')
@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url($user->background_url) }}") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
        }

        .cover-container{
            margin: 0;
            width: 100%;
            height: 350px;
            position: relative;
        }

        .cover-container:before{
            content: '';
            background-size: cover !important;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            position: absolute;
            background: url('https://media.gmodstore.com/script_banners/6fbf1d47322fc7733720a1e935e9196c_full.png') center center no-repeat;
            -webkit-mask: -webkit-gradient(linear,left top,left bottom,from(0),color-stop(0,transparent),to(#000));
            mask: -webkit-gradient(linear,left top,left bottom,from(0),color-stop(0,transparent),to(#000));
            mask: linear-gradient(0,transparent,#000);
        }
    </style>
    @endsection
@section('content')
    <div class="container">
        <div class="bg-brand-darkest-grey">
            <div class="d-flex flex-row">
                <div class="cover-container">
                    <div class="d-flex flex-row p-2 flex-fill align-self-stretch h-100">
                        <div class="mx-auto my-auto">
                            <div class="avatar mx-auto" style="width: 10rem; height: auto;">
                                <img src="{{$profile->avatar}}"/>
                            </div>
                            <h1 class="text-center mx-auto text-light pt-1 m-0">{{$profile->name}}</h1>
                            <h6 class="text-center mx-auto text-light m-0">Rank: Admin</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="p-4 bg-brand-darkest-grey">
            <div class="d-flex flex-row">

            </div>
        </div>
    </div>
    @endsection

