@extends(Config::get('chatter.master_file_extend'))
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

{{--style="background-color:{{ $discussion->category->color }}--}}

@section('content')

    @php
        $db_field = Config::get('chatter.user.avatar_image_database_field');
    @endphp

    <div class="container-fluid">
        <div class="p-4 bg-brand-darkest-grey">
            <div class="d-flex flex-row">
                <a class="my-auto px-2" href="/{{ Config::get('chatter.routes.home') }}"><i class="fas fa-chevron-left"></i></a>
                <div class="my-auto px-2">
                    <div class="avatar" style="width: 5rem; height: auto;">
                    @if(Config::get('chatter.user.avatar_image_database_field'))
                        <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                            @if( (substr($author[0]->{$db_field}, 0, 7) == 'http://') || (substr($author[0]->{$db_field}, 0, 8) == 'https://') )
                                <img src="{{ $author[0]->{$db_field}  }}">
                            @else
                                <img  src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $author[0]->{$db_field}  }}">
                            @endif

                        @else
                            <span class="chatter_avatar_circle">
					        					{{ ucfirst(substr($author->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
					        				</span>
                        @endif
                    </div>
                </div>
                <div class="flex-column flex-fill my-auto p-2">
                    <h3 class="my-auto text-white">{{ $discussion->title }}</h3>
                   <div class="flex-column">
                       <a  class="pr-1" href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.category') }}/{{ $discussion->category->slug }}">Category: {{ $discussion->category->name }}</a>
                       <div class="text-white-50">by: {{$author[0]->name}}</div>
                   </div>
                </div>
                @if(!Auth::guest() && (Auth::user()->id == $discussion->user_id))
                    <div class="flex-row mx-auto my-auto px-1">
                        <div class="btn btn-primary text-white-50 edit-post">
                            <i class="fas fa-pencil"></i> @lang('chatter::messages.words.edit')
                        </div>
                    </div>
                    <form class="flex-row mx-auto my-auto px-1" action="{{ action('ChatterDiscussionController@destroy',$discussion->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>


        @if(config('chatter.errors'))
            @if(Session::has('chatter_alert'))
                <div class="chatter-alert alert alert-{{ Session::get('chatter_alert_type') }}">
                    <div class="container">
                        <strong><i class="chatter-alert-{{ Session::get('chatter_alert_type') }}"></i> {{ Config::get('chatter.alert_messages.' . Session::get('chatter_alert_type')) }}</strong>
                        {{ Session::get('chatter_alert') }}
                        <i class="chatter-close"></i>
                    </div>
                </div>
                <div class="chatter-alert-spacer"></div>
            @endif

            @if (count($errors) > 0)
                <div class="chatter-alert alert alert-danger">
                    <div class="container">
                        <p><strong><i class="chatter-alert-danger"></i> @lang('chatter::alert.danger.title')</strong> @lang('chatter::alert.danger.reason.errors')</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif

        <div class="d-flex flex-column flex-fill mt-5">
            @foreach($posts as $post)
                @if($loop->first)
                    <div class="bg-brand-darkest-grey mb-5 rounded">
                        <div class="d-flex flex-row">
                            <div class="flex-column mx-auto p-5 author-overlay">
                                <div class="avatar" style="width: 6rem; height: auto;">
                                    @if(Config::get('chatter.user.avatar_image_database_field'))
                                        @if( (substr($post->user->{$db_field}, 0, 7) == 'http://') || (substr($post->user->{$db_field}, 0, 8) == 'https://') )
                                            <img src="{{ $post->user->{$db_field}  }}">
                                        @else
                                            <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $post->user->{$db_field}  }}">
                                        @endif

                                    @else
                                        <span class="chatter_avatar_circle" style="background-color:#<?= \App\Helpers\ChatterHelper::stringToColorCode($post->user->{Config::get('chatter.user.database_field_with_user_name')}) ?>">
					        					{{ ucfirst(substr($post->user->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
					        				</span>
                                    @endif
                                </div>
                                <div class="mx-auto my-auto pt-2 text-center">
                                    <a class="h3 text-light" href="{{ \App\Helpers\ChatterHelper::userLink($post->user) }}">{{ ucfirst($post->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</a>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-fill align-self-stretch">
                                <div class="text-muted pl-4 pt-2">Posted: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</div>
                                <div class="flex-row flex-fill align-self-stretch p-4 border-bottom border-brand-dark-grey text-white-50">
                                    {!! $post->body !!}
                                </div>
                                <div class="d-flex flex-row p-2 align-items-end ml-auto">
                                    @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                        <div class="px-1">
                                            <div class="btn btn-primary text-white-50 edit-post">
                                                <a href="{{ url(Config::get('chatter.routes.home') . '/posts/' . $post->id . '/edit')}}" class="text-light">
                                                    <i class="chatter-edit"></i> @lang('chatter::messages.words.edit')
                                                </a>
                                            </div>
                                        </div>
                                        <form class="px-1 m-0" action="{{ action('ChatterPostController@destroy',$post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-brand-darkest-grey mb-5 rounded">
                        <div class="d-flex flex-row">
                            <div class="flex-column mx-auto p-5 author-overlay">
                                <div class="avatar" style="width: 6rem; height: auto;">
                                    @if(Config::get('chatter.user.avatar_image_database_field'))
                                        @if( (substr($post->user->{$db_field}, 0, 7) == 'http://') || (substr($post->user->{$db_field}, 0, 8) == 'https://') )
                                            <img src="{{ $post->user->{$db_field}  }}">
                                        @else
                                            <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $post->user->{$db_field}  }}">
                                        @endif

                                    @else
                                        <span class="chatter_avatar_circle" style="background-color:#<?= \App\Helpers\ChatterHelper::stringToColorCode($post->user->{Config::get('chatter.user.database_field_with_user_name')}) ?>">
					        					{{ ucfirst(substr($post->user->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
					        				</span>
                                    @endif
                                </div>
                                <div class="mx-auto my-auto pt-2 text-center">
                                    <a class="h3 text-light" href="{{ \App\Helpers\ChatterHelper::userLink($post->user) }}">{{ ucfirst($post->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</a>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-fill align-self-stretch">
                                <div class="text-muted pl-4 pt-2">Posted: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</div>
                                <div class="flex-row flex-fill align-self-stretch p-4 border-bottom border-brand-dark-grey text-white-50">
                                    {!! $post->body !!}
                                </div>
                                <div class="d-flex flex-row p-2 align-items-end ml-auto">
                                    @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                        <div class="px-1">
                                            <div class="btn btn-primary text-white-50 edit-post">
                                                <a href="{{ url(Config::get('chatter.routes.home') . '/posts/' . $post->id . '/edit')}}" class="text-light">
                                                    <i class="chatter-edit"></i> @lang('chatter::messages.words.edit')
                                                </a>
                                            </div>
                                        </div>
                                        <form class="px-1 m-0" action="{{ action('ChatterPostController@destroy',$post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div id="pagination">{{ $posts->links() }}</div>

    @if(!Auth::guest())
            <div class="container-fluid" id="editor">
<div class="d-flex mx-auto flex-row align-items-center align-items-stretch">
    <div class="chatter_loader dark" id="new_discussion_loader">
        <div></div>
    </div>
    <form class="d-flex mx-auto flex-column" id="chatter_form_editor" action="/{{ Config::get('chatter.routes.home') }}/posts" method="POST">
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
        <input type="hidden" name="chatter_discussion_id" value="{{ $discussion->id }}">
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

@stop


@section(Config::get('chatter.yields.footer'))

    <script>var chatter_editor = 'trumbowyg';</script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/js/trumbowyg.js') }}"></script>

    <script src="{{ url('/vendor/devdojo/chatter/assets/js/chatter.js') }}"></script>

@stop
