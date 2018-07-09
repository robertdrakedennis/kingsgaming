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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    @yield('custom_css')
    @yield('forum_styles')
    <title>@yield('title')</title>
</head>
<body>
@yield('content')
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>