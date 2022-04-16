<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('chunks.head')
    <body class="front">
        <div id="app" class="app">

            @include('chunks.header')
            <main class="app__main">
                @yield('content')
            </main>
            @include('chunks.footer')
            <mobilemenu auth="{{auth()->check() ? true : false}}" menu="{{$mobileMenu}}"  token="{{ csrf_token() }}"></mobilemenu>
        </div>

        @include('chunks.forms')
        @include('chunks.includesFooter')
        @yield('page-script')
        @include('chunks.messages_alerts')

    </body>
</html>
