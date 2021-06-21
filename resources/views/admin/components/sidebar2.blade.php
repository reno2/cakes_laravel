
    <div class="sidebar2__top top p-2">
        <div class="top__front">
            <a class="to_front" href="{{ url('/') }}">

                <i class="fas fa-globe"></i> ВИТРИНА
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <hr>
        <div class="top__dashboard">
{{--            <a class="nav-link" href="{{route('admin.index')}}">--}}
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Панель</span></a>
        </div>
        <hr>
        <div class="top__middle">
            <ul class="sidebar__ul sul">
                <div class="sidebar-heading">
                    Interface
                </div>
                <li class="sul-link">
                    <a href="#" class="nav-link" id="dmenu" >Блог</a>

                    <div class="dmenu">
                        <a class="dropdown-item" href="{{route('admin.category.index')}}">Категории</a>
                        <a class="dropdown-item" href="{{route('admin.article.index')}}">Материалы</a>
                        <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>
                        <a class="dropdown-item" href="{{route('admin.features.index')}}">Характеристики</a>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        <ul class="sidebar__ul sul">
            <div class="sidebar-heading">
                SEO
            </div>
            <li class="sul-link">
                <a href="#" class="nav-link" id="dmenu" >Настройки</a>

                <div class="dmenu">
                    <a class="dropdown-item" href="{{route('seo.category.index')}}">Категории</a>
                    <a class="dropdown-item" href="{{route('seo.post.index')}}">Материалы</a>
                    <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>
                </div>
            </li>
        </ul>
        <hr>
        <ul class="sidebar__ul sul">
            <div class="sidebar-heading">
                Общие
            </div>
            <li class="sul-link">
                <a href="#" class="nav-link" id="dmenu" >Дополнительно</a>
                <div class="dmenu">
                    <a class="dropdown-item" href="{{route('admin.settings.index')}}">Настройки</a>
                    <a class="dropdown-item" href="{{route('seo.post.index')}}">Страницы</a>
                    <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>
                </div>
            </li>
        </ul>
        <div class="top__middle">
            <ul class="sidebar__ul sul">
                <div class="sidebar-heading">
                    Пользователи
                </div>
                <li class="sul-link">


                    <div class="dmenu">
                        <a class="dropdown-item" href="{{route('admin.users.index')}}">Список пользователей</a>
{{--                        <a class="dropdown-item" href="{{route('user_managment.user.create')}}">Создать</a>--}}
{{--                        <a class="dropdown-item" href="{{route('user_managment.user.create')}}">Роли</a>--}}
{{--                        <a class="dropdown-item" href="{{route('user_managment.user.create')}}">Создать роль</a>--}}

                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Collapsed Hamburger -->

    <!-- Branding Image -->


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

            <li class="nav-item dropdown">
{{--                <a href="{{route('admin.index')}}" class="nav-link">Панель состояния</a>--}}
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Блог</a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('admin.category.index')}}">Категории</a>
                    <a class="dropdown-item" href="{{route('admin.article.index')}}">Материалы</a>
{{--                    <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>--}}
                </div>
            </li>

            <li class="nav-item dropdown">
{{--                <a href="{{route('user_managment.user.index')}}" class="nav-link">Пользователи</a>--}}
            </li>


        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                       aria-haspopup="true" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>

</nav>
