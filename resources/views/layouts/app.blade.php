<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ h_secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ h_secure_asset('css/iziToast.css') }}" rel="stylesheet">
    <link href="{{ h_secure_asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="{{ h_secure_asset('js/iziToast.js') }}"></script>
</head>
<body>
<div id="app">
    @include('navigation.front-menu')
    @if(Auth::check() && is_admin(Auth::user()) && (Request::is('admin/*') || Request::is('admin')))
        @include('navigation.admin-menu')
    @endif
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warn'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('warn') }}
                        </div>
                    @endif
                </div>
            </div>
        @yield('content')
    </main>
</div>

</body>
</html>
