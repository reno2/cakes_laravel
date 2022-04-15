<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"  >
    @include('chunks.head')
    <body class="front">
        <div id="app">
            @include('chunks.header')
            <main class="app__main profile">
                <div class="container">
                    <div class="profile-content">
                        <div class="profile-content__sidebar">
                            @include('profile.sidebar')
                        </div>
                        <div class="profile-content__body">
                            @include('chunks.massages_errors')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
            <mobilemenu profile-menu="1" menu="{{$mobileMenu}}"></mobilemenu>
        </div>
        @include('chunks.footer')
        @include('chunks.includesFooter')
        @yield('page-script')
        @include('chunks.messages_alerts')
    </body>
</html>