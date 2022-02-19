<div class="dashboard-sidebar">

    <div class="dashboard-sidebar__block ">
        <div class="dashboard-sidebar__front">
            <a href="http://lara-auth.ru" class="dashboard-sidebar__logo">
                <img src="/images/full-logo.svg">
            </a>
        </div>
    </div>
    <div class="dashboard-sidebar__blocks">
        <div class="dashboard-sidebar__block sidebar-block">
            <div class="sidebar-block__menu js_menuWrap">
                <a href="{{route('admin.index')}}" class="sidebar-block__top js_menuToggle">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">Панель</span>
                    </span>
                </a>
            </div>
        </div>


        <div class="dashboard-sidebar__block sidebar-block">
            <div class="sidebar-block__menu js_menuWrap @if (Str::contains(URL::current(), 'content')) menu_isOpen @endif">
                <div class="sidebar-block__top js_menuToggle">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard-content')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">Контент</span>
                    </span>
                    <svg class="js_toggle__block sidebar-block__arrow">
                        <use xlink:href="{{asset('images/back-icons.svg#dashboard-arrow-right')}}"></use>
                    </svg>
                </div>
                <div class="sidebar-block__bottom js_menuContent">
                    <a class="sidebar-block__item" href="{{route('admin.category.index')}}">Категории</a>
                    <a class="sidebar-block__item" href="{{route('admin.article.index')}}">Материалы</a>
                    <a class="sidebar-block__item" href="{{route('admin.tags.index')}}">Теги</a>
                    <a class="sidebar-block__item" href="{{route('admin.features.index')}}">Характеристики</a>
                </div>
            </div>
        </div>

        <div class="dashboard-sidebar__block sidebar-block">

            <div class="sidebar-block__menu js_menuWrap @if (Str::contains(URL::current(), 'seo')) menu_isOpen @endif">
                <div class="sidebar-block__top js_menuToggle">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard-seo')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">SEO</span>
                    </span>
                    <svg class="js_toggle__block sidebar-block__arrow">
                        <use xlink:href="{{asset('images/back-icons.svg#dashboard-arrow-right')}}"></use>
                    </svg>
                </div>
                <div class="sidebar-block__bottom js_menuContent">
                    <a class="sidebar-block__item" href="{{route('seo.front.index')}}">Главная</a>
                    <a class="sidebar-block__item" href="{{route('seo.category.index')}}">Категории</a>
                    <a class="sidebar-block__item" href="{{route('seo.post.index')}}">Материалы</a>
                    <a class="sidebar-block__item" href="{{route('admin.tags.index')}}">Теги</a>
                </div>
            </div>

        </div>

        <div class="dashboard-sidebar__block sidebar-block">
            <div class="sidebar-block__menu js_menuWrap @if (Str::contains(URL::current(), 'seo')) menu_isOpen @endif">
                <div class="sidebar-block__top js_menuToggle">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard-more')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">Дополнительно</span>
                    </span>
                    <svg class="js_toggle__block sidebar-block__arrow">
                        <use xlink:href="{{asset('images/back-icons.svg#dashboard-arrow-right')}}"></use>
                    </svg>
                </div>
                <div class="sidebar-block__bottom js_menuContent">

                    <a class="sidebar-block__item" href="{{route('admin.settings.index')}}">Настройки</a>
                    <a class="sidebar-block__item" href="{{route('seo.post.index')}}">Страницы</a>
                    <a class="sidebar-block__item" href="{{route('admin.tags.index')}}">Теги</a>
                </div>
            </div>
        </div>
        <div class="dashboard-sidebar__block sidebar-block">
            <div class="sidebar-block__menu js_menuWrap @if (Str::contains(URL::current(), 'seo')) menu_isOpen @endif">
                <div class="sidebar-block__top js_menuToggle">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard-users')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">Пользователи</span>
                    </span>
                    <svg class="js_toggle__block sidebar-block__arrow">
                        <use xlink:href="{{asset('images/back-icons.svg#dashboard-arrow-right')}}"></use>
                    </svg>
                </div>
                <div class="sidebar-block__bottom js_menuContent">
                    <a class="sidebar-block__item" href="{{route('admin.users.index')}}">Список пользователей</a>
                </div>
            </div>
        </div>
        <div class="dashboard-sidebar__block sidebar-block">
            <div class="sidebar-block__menu @if (Str::contains(URL::current(), 'seo')) menu_isOpen @endif">
                <div class="sidebar-block__top">
                    <span class="sidebar-block__figure">
                        <svg class="sidebar-block__icon">
                            <use xlink:href="{{asset('images/back-icons.svg#dashboard-exit')}}"></use>
                        </svg>
                        <span class="sidebar-block__name">Выход</span>
                    </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(false)

        <div class="sidebar2__top top p-2">


            <div class="top__middle">
                <ul class="sidebar__ul sul">
                    <li class="sul-link d-menu js_menuWrap @if (Str::contains(URL::current(), 'content')) menu_isOpen @endif">
                        <a href="#" class="nav-link d-menu__toggle js_menuToggle" id="dmenu">
                            <span class="d-menu__title">Контент</span>
                            <i class="d-menu__arrow fas fa-chevron-right"></i>
                        </a>
                        <div class="d-menu__content js_menuContent">
                            <a class="dropdown-item d-menu__item" href="{{route('admin.category.index')}}">Категории</a>
                            <a class="dropdown-item d-menu__item" href="{{route('admin.article.index')}}">Материалы</a>
                            <a class="dropdown-item d-menu__item" href="{{route('admin.tags.index')}}">Теги</a>
                            <a class="dropdown-item d-menu__item" href="{{route('admin.features.index')}}">Характеристики</a>
                        </div>
                    </li>
                    <li class="sul-link d-menu js_menuWrap @if (Str::contains(URL::current(), 'seo')) menu_isOpen @endif">
                        <a href="#" class="nav-link d-menu__toggle js_menuToggle" id="dmenu">
                            <span class="d-menu__title">SEO</span>
                            <i class="d-menu__arrow fas fa-chevron-right"></i>
                        </a>
                        <div class="d-menu__content js_menuContent">
                            <a class="dropdown-item" href="{{route('seo.front.index')}}">Главная</a>
                            <a class="dropdown-item" href="{{route('seo.category.index')}}">Категории</a>
                            <a class="dropdown-item" href="{{route('seo.post.index')}}">Материалы</a>
                            <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>
                        </div>
                    </li>
                    <li class="sul-link d-menu js_menuWrap">
                        <a href="#" class="nav-link d-menu__toggle js_menuToggle" id="dmenu">
                            <span class="d-menu__title">Дополнительно</span>
                            <i class="d-menu__arrow fas fa-chevron-right"></i>
                        </a>
                        <div class="d-menu__content js_menuContent">
                            <a class="dropdown-item" href="{{route('admin.settings.index')}}">Настройки</a>
                            <a class="dropdown-item" href="{{route('seo.post.index')}}">Страницы</a>
                            <a class="dropdown-item" href="{{route('admin.tags.index')}}">Теги</a>
                        </div>
                    </li>
                    <li class="sul-link d-menu js_menuWrap">
                        <a href="#" class="nav-link d-menu__toggle js_menuToggle" id="dmenu">
                            <span class="d-menu__title">Пользователи</span>
                            <i class="d-menu__arrow fas fa-chevron-right"></i>
                        </a>
                        <div class="d-menu__content js_menuContent">
                            <a class="dropdown-item" href="{{route('admin.users.index')}}">Список пользователей</a>
                        </div>
                    </li>
                </ul>
            </div>
            <hr>
            @if(false)
                <ul class="sidebar__ul sul">
                    <div class="sidebar-heading">
                        SEO
                    </div>
                </ul>
                <hr>
                <ul class="sidebar__ul sul">
                    <div class="sidebar-heading">
                        Общие
                    </div>
                    <li class="sul-link">
                        <a href="#" class="nav-link" id="dmenu">Дополнительно</a>
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
            @endif
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
                       aria-haspopup="true" aria-expanded="false">Блог
                    </a>

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
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
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

    @endif

</div>