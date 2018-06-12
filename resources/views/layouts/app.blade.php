<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SCADI</title>

        <!-- Styles -->
        <link rel=icon href="{{asset('img/gladio.png')}}" sizes="16x16" type="image/png">
        <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script> var laravel_token = '{{ csrf_token() }}';</script>
        <script> var asset = "{{asset('/')}}"</script>
    </head>
    <body>
        <div id="app">
            @yield('header')
            @yield('navbar')

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
