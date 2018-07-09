@extends('layouts.back.main')

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
    <div class="container">
        <div class="table-responsive">
            <table class="table bg-brand-darkest-grey text-white border-0 table-borderless table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">avatar</th>
                    <th scope="col">Username</th>
                    <th scope="col">Steamid</th>
                    <th scope="col">IP</th>
                    <th scope="col">Rank</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td><img src="{{$user->avatar}}" style="width: 2.5rem; height: auto; -webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;"></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->steamid}}</td>
                        <td>{{$user->registered_ip}}</td>
                        @if($user->hasRole('Administrator'))
                            <td>Administrator</td>
                        @elseif($user->hasRole('User'))
                            <td>User</td>
                        @elseif($user->hasRole('BannedFromPosting'))
                            <td>Banned From Posting</td>
                        @elseif($user->hasRole('BannedFromEverything'))
                            <td>Banned From Everything</td>
                        @elseif(($user->hasRole('Administrator')) && $user->hasRole('User')))
                        <td>Administrator, User</td>
                        @elseif(($user->hasRole('Administrator')) && $user->hasRole('BannedFromEverything')))
                        <td>Administrator, Banned</td>
                        @elseif(($user->hasRole('Administrator')) && $user->hasRole('User')))
                        <td>Administrator, User, Banned</td>
                            @else
                            <td></td>
                        @endif
                        <td>
                                <form action="{{ action('AdminPanelController@banFromEverything', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Ban from everything</button>
                                </form>
                        </td>
                        <td>
                                <form action="{{ action('AdminPanelController@banFromPosting', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Ban from posting</button>
                                </form>
                        </td>
                        {{--<td>--}}
                            {{--<a href="{{url('/admin/' . $user->id .'/banFromEverything')}}" class="btn btn-danger">Ban from Everything</a>--}}

                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<a href="{{url('/admin/' . $user->id .'/banFromPosting')}}" class="btn btn-danger">Ban from Posting</a>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                {{ $users->links() }}
                </tbody>
            </table>
        </div>
    </div>

@endsection
