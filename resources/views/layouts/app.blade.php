<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('chunks.head')
    <body class="front">
        <div id="app">

            @include('chunks.header')
            <main class="py-4">
                @yield('content')
            </main>
        </div>

        @include('chunks.footer')
        @include('chunks.includesFooter')
        @yield('page-script')
        @include('chunks.messages_alerts')
    </body>
</html>
