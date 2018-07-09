@extends('layouts.front.main')
@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url('img/bg.svg') }}") no-repeat top left local;
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
            background: url('{{$profile->background_url}}') center center no-repeat;
            -webkit-filter: grayscale(75%); /* Safari 6.0 - 9.0 */
            filter: grayscale(75%);
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
                            <h6 class="text-center mx-auto text-light m-0">Rank: Placeholder</h6>
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

