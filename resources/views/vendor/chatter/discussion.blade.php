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

    <div class="container">
        <div class="p-4 bg-brand-darkest-grey">
            <div class="d-flex flex-row">
                <a class="my-auto pr-5" href="/{{ Config::get('chatter.routes.home') }}"><i class="fas fa-chevron-left"></i></a>
                <h1 class="my-auto text-white pr-3">{{ $discussion->title }}</h1>
                <div class="flex-column w-75 my-auto">
                    <div class="text-white-50">
                        @lang('chatter::messages.discussion.head_details')
                    </div>
                    <a href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.category') }}/{{ $discussion->category->slug }}">
                        {{ $discussion->category->name }}</a>
                    <div class="text-white-50">
                        by: {{$author[0]->name}}
                    </div>
                </div>
                <div class="flex-row mx-auto my-auto">
                    <div class="avatar">
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
                    <div class="p-3 bg-brand-darkest-grey mb-5" style="display:block;">
                        <div class="d-flex flex-row">
                            <div class="flex-column mx-auto my-auto">
                                <div class="avatar">
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
                                <div class="mx-auto my-auto text-center">
                                    <a href="{{ \App\Helpers\ChatterHelper::userLink($post->user) }}">{{ ucfirst($post->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</a>
                                </div>

                                @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                @endif
                            </div>
                            <div class="flex-row flex-fill flex- my-auto p-5">
                                <div class="text-white-50">
                                    <?= $post->body; ?>
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="px-1 mx-auto my-auto">
                                    <div class="btn btn-primary text-white-50 edit-post">
                                        <i class="chatter-edit"></i> @lang('chatter::messages.words.edit')
                                    </div>
                                </div>
                                <form class="px-1 mx-auto my-auto" action="{{ action('ChatterPostController@destroy',$post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <div class="flex-column mt-auto text-white-50 px-3">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</div>

                            </div>
                        </div>
                    </div>
                @else
               <div class="p-3 bg-brand-darkest-grey" style="display:block;">
                   <div class="d-flex flex-row">
                       <div class="flex-column mx-auto my-auto">
                           <div class="avatar">
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
                           <div class="mx-auto my-auto text-center">
                               <a href="{{ \App\Helpers\ChatterHelper::userLink($post->user) }}">{{ ucfirst($post->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</a>
                           </div>

                           @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                           @endif
                       </div>
                       <div class="flex-row flex-fill flex- my-auto p-5">
                           <div class="text-white-50">
                               <?= $post->body; ?>
                           </div>
                       </div>
                       <div class="d-flex flex-row">
                           <div class="px-1 mx-auto my-auto">
                               <div class="btn btn-primary text-white-50 edit-post">
                                   <i class="chatter-edit"></i> @lang('chatter::messages.words.edit')
                               </div>
                           </div>
                           <form class="px-1 mx-auto my-auto" action="{{ action('ChatterPostController@destroy',$post->id) }}" method="POST">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-danger">Delete</button>
                           </form>
                           <div class="flex-column mt-auto text-white-50 px-3">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</div>

                       </div>
                   </div>
               </div>
                @endif
            @endforeach
        </div>
    </div>

    <div id="pagination">{{ $posts->links() }}</div>

    @if(!Auth::guest())
        <div id="new_response">
            <div class="chatter_avatar">
            @if(Config::get('chatter.user.avatar_image_database_field'))
                <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>
                <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                    @if( (substr(Auth::user()->{$db_field}, 0, 7) == 'http://') || (substr(Auth::user()->{$db_field}, 0, 8) == 'https://') )
                        <img src="{{ Auth::user()->{$db_field}  }}">
                    @else
                        <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . Auth::user()->{$db_field}  }}">
                    @endif
                @else
                    <span class="chatter_avatar_circle" style="background-color:#<?= \App\Helpers\ChatterHelper::stringToColorCode(Auth::user()->{Config::get('chatter.user.database_field_with_user_name')}) ?>">
		        					{{ strtoupper(substr(Auth::user()->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
		        				</span>
                @endif
            </div>

            <div id="new_discussion">
                <div class="chatter_loader dark" id="new_discussion_loader">
                    <div></div>
                </div>
                <form id="chatter_form_editor" action="/{{ Config::get('chatter.routes.home') }}/posts" method="POST">
                    <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">
                    <input type="hidden" name="chatter_discussion_id" value="{{ $discussion->id }}">
                    <!-- BODY -->
                    <div id="editor">
                        <textarea class="trumbowyg" name="body" placeholder="Type Your Discussion Here...">{{ old('body') }}</textarea>
                    </div>
                    <button id="submit_response" class="btn btn-success pull-right"><i class="chatter-new"></i> @lang('chatter::messages.response.submit')</button>
                </form>

            </div><!-- #new_discussion -->
        </div>
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
