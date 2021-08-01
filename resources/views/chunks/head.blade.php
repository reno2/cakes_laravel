<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

@yield('title')
{{ SeometaFacade::getData() }}
{{--    {!! SeometaFacade::renderTag('title') !!}--}}
{{--    {!! SeometaFacade::renderTag('keywords') !!}--}}
{{--    {!! SeometaFacade::renderTag('description') !!}--}}
<!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
</head>
