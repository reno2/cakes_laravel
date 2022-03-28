<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('chunks.head')

    <body class="front">
        <div id="app">
            @include('chunks.header')
            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center profile-content">
                        <div class="col-md-3 profile-content__sidebar">
                            @include('profile.sidebar')
                        </div>
                        <div class="col-md-9 profile-content__body">
                            @include('chunks.massages_errors')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('chunks.footer')

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/main.js')}}"></script>
        <script src="{{ asset('js/modal.js') }}"></script>
        <script src="{{ asset('js/toggleBlock.js')}}"></script>
        <script src="{{ asset('js/header.js')}}"></script>
        <script src="{{ asset('js/js_forms.js')}}"></script>
        @yield('page-script')
        @include('chunks.messages_alerts')
    </body>
</html>
