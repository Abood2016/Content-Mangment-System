<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('front-assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/style.css') }}">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home | Bookshop Responsive Bootstrap4 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="images/icon.png">

    <link href="{{ asset('front-assets/js/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" rel="stylesheet"
        type="text/css" />
    <script src="{{ asset('front-assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    @yield('style')
</head>

<body>
    <div id="app">
        <div class="wrapper" id="wrapper">
            @include('partial.frontend.header')
            <main>
                @include('partial.flash')
                @yield('content')
            </main>
            @include('partial.frontend.footer')
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- JS Files -->

    <script src="{{ asset('front-assets/js/plugins.js') }}"></script>
    <script src="{{ asset('front-assets/js/active.js') }}"></script>

    
    <script src="{{ asset('front-assets/js/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>

    <script src="{{ asset('front-assets/js/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap-fileinput/themes/fa/theme.js') }}"></script>

    <script src="{{ asset('front-assets/js/custom.js') }}"></script> <!-- Added By me -->

    @yield('script')
</body>

</html>