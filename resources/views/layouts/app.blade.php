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
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/modal.js') }}"></script>
        <script src="{{ asset('js/main.js')}}"></script>
        <script src="{{ asset('js/inputs.js')}}"></script>
        <script src="{{ asset('js/header.js')}}"></script>
        @yield('page-script')
        @include('chunks.messages')
    </body>
</html>
