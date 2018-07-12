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
    <div class="container-fluid">
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
                        <td>
                            @foreach($user->roles as $role)
                                {{$role->name}},
                        @endforeach
                        </td>

                        @if($user->hasRole('BannedFromEverything'))
                            <td>
                                <form action="{{ action('AdminPanelController@unbanFromEverything', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Unban from everything</button>
                                </form>
                            </td>

                        @elseif($user->hasRole('User'))
                            <td>
                                <form action="{{ action('AdminPanelController@banFromEverything', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Ban from everything</button>
                                </form>
                            </td>
                        @elseif($user->hasRole('Administrator'))
                            <td>
                                <form action="#" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger" disabled>Ban from everything</button>
                                </form>
                            </td>
                        @elseif($user->hasRole('BannedFromPosting'))
                            <td>
                                <form action="{{ action('AdminPanelController@banFromEverything', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Ban from everything</button>
                                </form>
                            </td>
                        @endif
                        @if($user->hasrole('BannedFromPosting'))
                            <td>
                                <form action="{{ action('AdminPanelController@unbanFromPosting', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Unban from posting</button>
                                </form>
                            </td>
                            @elseif($user->hasrole('Administrator'))
                        <td>
                            <form action="#" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger" disabled>Ban from posting</button>
                            </form>
                        </td>
                            @else
                            <td>
                                <form action="{{ action('AdminPanelController@banFromPosting', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Ban from posting</button>
                                </form>
                            </td>
                        @endif
                        @if($user->hasRole('User'))
                        <td>
                            <form action="{{ action('AdminPanelController@setRoleAdministrator', $user->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger">Set Administrator</button>
                            </form>
                        </td>
                        @elseif($user->hasRole('BannedFromEverything') || $user->hasRole('BannedFromPosting'))
                            <td>
                                <form action="#" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger" disabled>Unban first...</button>
                                </form>
                            </td>
                            @elseif($user->hasRole('Administrator'))
                            <td>
                                <form action="{{ action('AdminPanelController@setRoleUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Demote</button>
                                </form>
                            </td>
                            @endif
                    </tr>
                @endforeach
                {{ $users->links() }}
                </tbody>
            </table>
        </div>
    </div>

@endsection
