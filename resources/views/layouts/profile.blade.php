<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"  >
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
        @include('chunks.includesFooter')
        @yield('page-script')
        @include('chunks.messages_alerts')
    </body>
</html>