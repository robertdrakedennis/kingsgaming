@extends(Config::get('chatter.master_file_extend'))
@section('custom_css')
    <style>
        body{
            background: #121416 url("{{ url('img/bg.svg') }}") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
        }
    </style>
    <link rel="stylesheet" href="{{url('/vendor/trumbowyg/ui/trumbowyg.css')}}">
    <link rel="stylesheet" href="{{ url('/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.css') }}">
@endsection
@section('content')
    @if(config('chatter.errors'))
        @if(Session::has('chatter_alert'))
            <div class="alert alert-{{ Session::get('chatter_alert_type') }}">
                <div class="container">
                    <strong><i class="fas fa-{{ Session::get('chatter_alert_type') }}"></i> {{ Config::get('chatter.alert_messages.' . Session::get('chatter_alert_type')) }}</strong>
                    {{ Session::get('chatter_alert') }}
                    <i class="fas fa-close"></i>
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

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- SIDEBAR -->
                <div class="">
                    <div class="pb-2">
                        <a class="btn btn-brand-primary" href="/{{ Config::get('chatter.routes.home') }}"><i class="chatter-bubble"></i> @lang('chatter::messages.discussion.all')</a>
                        @auth
                            <button class="btn btn-brand-white" data-toggle="modal" data-target="#newDiscussionModal"><i class="chatter-new"></i> @lang('chatter::messages.discussion.new')</button>
                        @endauth

                        @guest
                            <a class="btn btn-brand-white" href="{{route('login.steam')}}"><i class="fab fa-steam"></i> Sign in through Steam</a>
                        @endguest
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
                        <a class="navbar-brand" href="#">Categories</a>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                @foreach($categories as $category)
                                    <a class="nav-item nav-link" href="/{{Config::get('chatter.routes.home') . '/' . Config::get('chatter.routes.category') . '/' . $category['slug']}}">{{$category->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- END SIDEBAR -->
            </div>
            <div class="container-fluid">
                <div class="p-3 bg-brand-darkest-grey">
                    @foreach($discussions as $discussion)
                        <div class="d-flex flex-row p-3">
                                <div class="flex-column my-auto" style="min-width: 70%;">
                                <div>
                                    <a class="h3 text-white" href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}/{{ $discussion->category->slug }}/{{ $discussion->slug }}">{{ $discussion->title }}</a>
                                </div>
                                <div class="text-muted">Category: {{ $discussion->category->name }}</div>
                            </div>
                            <div class="flex-column my-auto">
                                <div class="text-white text-right">{{ $discussion->postsCount[0]->total }}</div>
                            </div>
                        @if(Config::get('chatter.user.avatar_image_database_field'))
                            <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>
                            <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                                @if( (substr($discussion->user->{$db_field}, 0, 7) == 'http://') || (substr($discussion->user->{$db_field}, 0, 8) == 'https://') )
                                    <div class="flex-column px-3 mx-auto my-auto">
                                        <div class="avatar">
                                            <img src="{{ $discussion->user->{$db_field}  }}" style="border: 3px solid {{ $discussion->category->color }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="flex-column mx-auto my-auto px-3">
                                        <div class="avatar">
                                            <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $discussion->user->{$db_field}  }}">
                                        </div>
                                    </div>
                                @endif
                            @else
                                <span class="chatter_avatar_circle">
					        					{{ strtoupper(substr($discussion->user->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
					        				</span>

                            @endif
                            <div class="flex-column my-auto mx-auto w-25">
                                <div class="text-white">{{ucfirst($discussion->user->{Config::get('chatter.user.database_field_with_user_name')})}}</div>
                                <div class="text-muted">@lang('chatter::messages.discussion.posted_by') <span data-href="/user">{{ ucfirst($discussion->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</span> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($discussion->created_at))->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div id="pagination">
                    {{ $discussions->links() }}
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="newDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="newDiscussionModalLabel" aria-hidden="true">
        <form action="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}" method="POST">
        <div class="modal-dialog w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a Thread</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                        <!-- BODY -->
                        <div class="container" id="editor">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" class="form-control" id="title" name="title" placeholder="A simple title..." value="{{ old('title') }}" >
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Category</span>
                                </div>
                                <select id="chatter_category_id" class="form-control" name="chatter_category_id">
                                    <option value="">@lang('chatter::messages.editor.select')</option>
                                    @foreach($categories as $category)
                                        @if(old('chatter_category_id') == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @elseif(!empty($current_category_id) && $current_category_id == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div id="new_discussion_loader">
                                <div></div>
                            </div>
                            <textarea class="trumbowyg" id="chatter_form_editor" name="body" placeholder="@lang('chatter::messages.editor.tinymce_placeholder')">{{ old('body') }}</textarea>
                            <input type='text' id="color" name="color" />
                            <span class="select_color_text">@lang('chatter::messages.editor.select_color_text')</span>
                        </div>
                        <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">
                        <input type="hidden" id="current_path" value="{{ Request::path() }}">

                        <div style="clear:both"></div>
                        <div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit_discussion" class="btn btn-success pull-right"><i class="chatter-new"></i> @lang('chatter::messages.discussion.create')</button>
                </div>
            </div>
        </div>
            </form>
        </div>


@endsection

@section(Config::get('chatter.yields.footer'))
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/js/trumbowyg.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.js') }}"></script>
    <script>

        $('document').ready(function(){
            $("#color").spectrum({
                color: "#333639",
                preferredFormat: "hex",
                containerClassName: 'chatter-color-picker',
                cancelText: '',
                chooseText: 'close',
                move: function(color) {
                    $("#color").val(color.toHexString());
                }
            });

            @if (count($errors) > 0)
            $('#new_discussion').slideDown();
            $('#title').focus();
            @endif


        });

    </script>
@stop
