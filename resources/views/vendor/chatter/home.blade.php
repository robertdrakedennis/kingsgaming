@extends(Config::get('chatter.master_file_extend'))
@section('custom_css')
    <style>
        body{
            background: #121416 url("img/bg.svg") no-repeat top left local;
            -webkit-background-size: cover;
            background-size: cover;
        }
    </style>
    <link rel="stylesheet" href="/vendor/trumbowyg/ui/trumbowyg.css">
@endsection
@section('content')

    {{--<div id="chatter">--}}
    {{--<div id="chatter_hero">--}}
    {{--<div id="chatter_hero_dimmer"></div>--}}
    {{--<?php $headline_logo = Config::get('chatter.headline_logo'); ?>--}}
    {{--@if( isset( $headline_logo ) && !empty( $headline_logo ) )--}}
    {{--<img src="{{ Config::get('chatter.headline_logo') }}">--}}
    {{--@else--}}
    {{--<h1>@lang('chatter::intro.headline')</h1>--}}
    {{--<p>@lang('chatter::intro.description')</p>--}}
    {{--@endif--}}
    {{--</div>--}}

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

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- SIDEBAR -->
                <div class="">
                    <div class="pb-2">
                        <button class="btn btn-primary" id="new_discussion_btn"><i class="chatter-new"></i> @lang('chatter::messages.discussion.new')</button>
                        <a href="/{{ Config::get('chatter.routes.home') }}"><i class="chatter-bubble"></i> @lang('chatter::messages.discussion.all')</a>

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
                            <div class="d-flex flex-column p-3">
                                <div class="my-auto d-inline-block">
                                @if(Config::get('chatter.user.avatar_image_database_field'))
                                    <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>
                                    <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                                        @if( (substr($discussion->user->{$db_field}, 0, 7) == 'http://') || (substr($discussion->user->{$db_field}, 0, 8) == 'https://') )
                                            <div class="avatar">
                                                <img src="{{ $discussion->user->{$db_field}  }}" style="border: 3px solid {{ $discussion->category->color }}">
                                                <h6>{{ucfirst($discussion->user->{Config::get('chatter.user.database_field_with_user_name')})}}</h6>
                                            </div>
                                        @else
                                            <div class="avatar">
                                                <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $discussion->user->{$db_field}  }}">
                                                <h6>{{$discussion->user->Config::get('chatter.user.database_field_with_user_name')}}</h6>
                                            </div>
                                        @endif

                                    @else

                                        <span class="chatter_avatar_circle">
					        					{{ strtoupper(substr($discussion->user->{Config::get('chatter.user.database_field_with_user_name')}, 0, 1)) }}
					        				</span>

                                    @endif
                                </div>
                                <div class="my-auto">
                                    <a class="h3 text-white" href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}/{{ $discussion->category->slug }}/{{ $discussion->slug }}">
                                      {{ $discussion->title }}
                                    </a>
                                </div>
                                <div class="text-muted">Category: {{ $discussion->category->name }}</div>
                                <div class="text-white-50">
                                    @if($discussion->post[0]->markdown)
                                        <?php $discussion_body = GrahamCampbell\Markdown\Facades\Markdown::convertToHtml( $discussion->post[0]->body ); ?>
                                    @else
                                        <?php $discussion_body = $discussion->post[0]->body; ?>
                                    @endif
                                    <p>{{ substr(strip_tags($discussion_body), 0, 200) }}@if(strlen(strip_tags($discussion_body)) > 200){{ '...' }}@endif</p>
                                </div>
                                <span class="text-muted">@lang('chatter::messages.discussion.posted_by') <span data-href="/user">{{ ucfirst($discussion->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</span> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($discussion->created_at))->diffForHumans() }}</span>

                            </div>

                            <div class="d-flex flex-column">
                            </div>


                            <div class="col-lg-12">
                                <div class="chatter_count"><i class="chatter-bubble"></i> {{ $discussion->postsCount[0]->total }}</div>
                            </div>
                        @endforeach

                </div>

                <div id="pagination">
                    {{ $discussions->links() }}
                </div>

            </div>
        </div>
    </div>

    <div id="new_discussion">


        <div class="chatter_loader dark" id="new_discussion_loader">
            <div></div>
        </div>

        <form id="chatter_form_editor" action="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}" method="POST">
            <div class="d-flex flex-column">
                <div class="m-2">
                    <!-- TITLE -->
                    <input type="text" class="form-control" id="title" name="title" placeholder="@lang('chatter::messages.editor.title')" value="{{ old('title') }}" >
                </div>

                <div class="m-2">
                    <!-- CATEGORY -->
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

                <div class="text-white">
                    <i class="fas fa-close"></i>
                </div>
            </div><!-- .row -->

            <!-- BODY -->
            <div class="d-flex m-2" id="editor">
                <textarea class="trumbowyg" name="body" placeholder="@lang('chatter::messages.editor.tinymce_placeholder')">{{ old('body') }}</textarea>
            </div>

            <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">

            <div id="new_discussion_footer">
                <input type='text' id="color" name="color" /><span class="select_color_text">@lang('chatter::messages.editor.select_color_text')</span>
                <button id="submit_discussion" class="btn btn-success pull-right"><i class="chatter-new"></i> @lang('chatter::messages.discussion.create')</button>
                <a href="/{{ Config::get('chatter.routes.home') }}" class="btn btn-default pull-right" id="cancel_discussion">@lang('chatter::messages.words.cancel')</a>
                <div style="clear:both"></div>
            </div>
        </form>

    </div><!-- #new_discussion -->

    </div>

    @if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
        <input type="hidden" id="chatter_tinymce_toolbar" value="{{ Config::get('chatter.tinymce.toolbar') }}">
        <input type="hidden" id="chatter_tinymce_plugins" value="{{ Config::get('chatter.tinymce.plugins') }}">
    @endif
    <input type="hidden" id="current_path" value="{{ Request::path() }}">

@endsection

@section(Config::get('chatter.yields.footer'))


    @if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
        <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ url('/vendor/devdojo/chatter/assets/js/tinymce.js') }}"></script>
        <script>
            var my_tinymce = tinyMCE;
            $('document').ready(function(){
                $('#tinymce_placeholder').click(function(){
                    my_tinymce.activeEditor.focus();
                });
            });
        </script>
    @elseif($chatter_editor == 'simplemde')
        <script src="{{ url('/vendor/devdojo/chatter/assets/js/simplemde.min.js') }}"></script>
        <script src="{{ url('/vendor/devdojo/chatter/assets/js/chatter_simplemde.js') }}"></script>
    @elseif($chatter_editor == 'trumbowyg')
        <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
        <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script>
        <script src="{{ url('/vendor/devdojo/chatter/assets/js/trumbowyg.js') }}"></script>
    @endif

    <script src="{{ url('/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.js') }}"></script>
    <script src="{{ url('/vendor/devdojo/chatter/assets/js/chatter.js') }}"></script>
    <script>
        $('document').ready(function(){

            $('.chatter-close, #cancel_discussion').click(function(){
                $('#new_discussion').slideUp();
            });
            $('#new_discussion_btn').click(function(){
                @if(Auth::guest())
                    window.location.href = "{{ route('login.steam') }}";
                @else
                $('#new_discussion').slideDown();
                $('#title').focus();
                @endif
            });

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
