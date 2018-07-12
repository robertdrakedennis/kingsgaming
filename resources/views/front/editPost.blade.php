@extends('layouts.front.main')
@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url('img/bg.svg') }}") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
        }

        .trumbowyg-box, .trumbowyg-editor {
            margin: 0px auto;
        }
    </style>
    <link rel="stylesheet" href="{{url('/vendor/trumbowyg/ui/trumbowyg.css')}}">
    <link rel="stylesheet" href="{{ url('/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.css') }}">
    @endsection
@section('content')
    @php
        $db_field = Config::get('chatter.user.avatar_image_database_field');
    @endphp
    @if(!Auth::guest())
        <div class="container-fluid" id="editor">
            <div class="d-flex mx-auto flex-row align-items-center align-items-stretch flex-fill">
                <div class="chatter_loader dark" id="new_discussion_loader">
                    <div></div>
                </div>
                    <form class="d-flex mx-auto flex-column" action='/{{ Config::get('chatter.routes.home') }}/posts/{{$post->id}}' method='POST' enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        @method('PATCH')
                    <div class="avatar mr-2">
                    @if(Config::get('chatter.user.avatar_image_database_field'))
                        <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>
                        <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                            @if( (substr(Auth::user()->{$db_field}, 0, 7) == 'http://') || (substr(Auth::user()->{$db_field}, 0, 8) == 'https://') )
                                <img src="{{ Auth::user()->{$db_field}  }}">
                            @else
                                <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . Auth::user()->{$db_field}  }}">
                            @endif
                        @else
                            <span class="avatar" style="background-color:#<?= \App\Helpers\ChatterHelper::stringToColorCode(Auth::user()->{Config::get('chatter.user.database_field_with_user_name')}) ?>">
		        					{{ strtoupper(substr(Auth::user()->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
		        				</span>
                        @endif
                    </div>
                    <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">
                    <input type="hidden" name="chatter_discussion_id" value="{{ $post->id }}">
                    <!-- BODY -->
                    <div id="editor">
                        <textarea class="trumbowyg" name="body" placeholder="Type Your Discussion Here...">{{ old('body') }}</textarea>
                    </div>
                    <button id="submit_response" class="btn btn-success pull-right"><i class="chatter-new"></i> @lang('chatter::messages.response.submit')</button>
                </form>

            </div>
        </div><!-- #new_discussion -->

    @else
        <div id="login_or_register">
            <p>@lang('chatter::messages.auth', ['home' => Config::get('chatter.routes.home')])</p>
        </div>

    @endif
    <input type="hidden" id="current_path" value="{{ Request::path() }}">
@endsection

@section(Config::get('chatter.yields.footer'))

    <script>var chatter_editor = 'trumbowyg';</script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/js/trumbowyg.js') }}"></script>

    <script src="{{ url('/vendor/devdojo/chatter/assets/js/chatter.js') }}"></script>

@stop
