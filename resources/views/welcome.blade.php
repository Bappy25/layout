<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(!empty($welcome))
    <meta name="keywords" content="{{ $welcome->keywords }}"/>
    <meta name="description" content="{{ substr($welcome->description, 0, 20).'...' }}">
    @endif

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">

            @if(Auth::guard('admin')->check())
            <a href="{{ route('back.home') }}">MDB Admin Panel</a>

            @elseif(Auth::check())
            <a href="{{ url('/home') }}">Home</a>

            @else
            <a href="{{ route('login') }}">Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            <a href="{{ route('back.login') }}">Admin Login</a>
            @if (Route::has('back.register'))
            <a href="{{ route('back.register') }}">Admin Register</a>
            @endif
            
            @endif
            <a href="{{ route('news.index') }}">News</a>
            <a href="{{ route('about_us') }}">About</a>
            <a href="{{ route('terms_of_use') }}">Privacy Policy</a>
            <a href="{{ route('privacy_policy') }}">Terms of Use</a>
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Laravel Layout
            </div>

            <div class="links">
                <a href="https://laravel.com/docs">Docs</a>
                <a href="https://laracasts.com">Laracasts</a>
                <a href="https://laravel-news.com">News</a>
                <a href="https://blog.laravel.com">Blog</a>
                <a href="https://nova.laravel.com">Nova</a>
                <a href="https://forge.laravel.com">Forge</a>
                <a href="https://github.com/laravel/laravel">GitHub</a>
            </div>
        </div>
    </div>
</body>
</html>
