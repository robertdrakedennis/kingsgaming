<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="https://kingsgaming.us/img/sharer_logo.png">
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:title" content="Kings Gaming">
    <meta property="og:description" content="The best of the best.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kingsgaming.us">
    <meta property="og:site_name" content="Kings Gaming">
    <meta property="og:locale" content="en_US">
    <meta name="keywords" content="gmod, gmod darkrp, best darkrp servers, best darkrp, best darkrp gmod, gmod server, us gmod darkrp server">
    <meta name="theme-color" content="#3d6594">
    <link rel="icon" href="https://kingsgaming.us/img/logo-full.svg" sizes="any" type="image/svg+xml">
    <link rel="canonical" href="https://kingsgaming.us" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/aos.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    @yield('custom_css')
    <title>@yield('title')</title>
</head>
<body>

<nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bg-transparent pt-3 pb-2 pl-5">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="nav-item h-auto navbar-brand" style="width: 2rem">
                <img src="https://kingsgaming.us/img/logo-full.svg" data-aos="fade-in" data-aos-delay="250" data-aos-easing="ease-in-out-cubic">
            </li>
            <li class="nav-item {{ Route::currentRouteName() !== 'home' ?: 'active' }} px-2" data-aos="fade-up" data-aos-delay="250" data-aos-easing="ease-in-out-cubic">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item px-2" data-aos="fade-up" data-aos-delay="350" data-aos-easing="ease-in-out-cubic">
                <a class="nav-link" href="/store">Store</a>
            </li>
            <li class="nav-item px-2" data-aos="fade-up" data-aos-delay="450" data-aos-easing="ease-in-out-cubic">
                <a class="nav-link" href="/community">Community</a>
            </li>
            <li class="nav-item px-2 {{ Route::currentRouteName() !== 'leaderboard' ?: 'active' }}" data-aos="fade-up" data-aos-delay="550" data-aos-easing="ease-in-out-cubic">
                <a class="nav-link" href="{{route('leaderboard')}}">Leaderboard</a>
            </li>
            <li class="nav-item px-2 dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-aos="fade-up" data-aos-delay="650" data-aos-easing="ease-in-out-cubic">Social</a>
            <div class="dropdown-menu fade text-black-50 bg-white" aria-labelledby="dropdown">
            <a class="dropdown-item text-black-50 no-hover" href="{{route('discord')}}">Discord</a>
            <a class="dropdown-item text-black-50 no-hover" href="{{route('steam')}}">Steam</a>
            </div>
        </ul>

        {{--<ul class="nav navbar-nav navbar-right">--}}
            {{--<li>--}}
                {{--<a class="nav-link" href="#" aria-haspopup="true" aria-expanded="false">--}}
                {{--<div class="avatar">--}}
                    {{--<img src="#">--}}
                {{--</div></a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    </div>
</nav>
    @yield('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="footer-pad text-white-50">
                <h4>Helpful links</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50"></a></li>
                    <li><a href="https://kingsgaming.us/discord" class="text-white-50">Discord Link</a></li>
                    <li><a href="https://kingsgaming.us/server" class="text-white-50">Connect to Server</a></li>
                    <li><a href="https://kingsgaming.us/community" class="text-white-50">Forums</a></li>
                    <li><a href="https://kingsgaming.us/community/forum/6-announcements/" class="text-white-50">News and Updates</a></li>
                    <li><a href="https://kingsgaming.us/community/topic/22-official-rules-subject-to-change/" class="text-white-50">Rules</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="footer-pad text-white-50">
                <h4>Helpful links continued</h4>
                <ul class="list-unstyled">
                    <li><a href="https://kingsgaming.us/store/splash.php" class="text-white-50">Store</a></li>
                    <li><a href="https://steamcommunity.com/sharedfiles/filedetails/?id=1401104376" class="text-white-50">Workshop Link</a></li>
                    <li><a href="https://kingsgaming.us/community/forum/5-applications/" class="text-white-50">Apply for Staff</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/jquery.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/aos.js') }}"></script>
<script>
    AOS.init();
</script>
@yield('extra_scripts')
</body>
</html>