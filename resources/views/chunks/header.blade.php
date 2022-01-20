<header>
    <div class="header-top">
        <div class="container">
            <div class="header-top__inner">
                <ul class="header-top__ul">
                    <li class="header-top__li">
                        <a href="" class="header-top__link">Условия</a>
                    </li>
                    <li class="header-top__li">
                        <a href="" class="header-top__link">Правила</a>
                    </li>
                    <li class="header-top__li">
                        <a href="" class="header-top__link">Партнёрам</a>
                    </li>
                </ul>
                <div class="header-top__cities">
                    Санкт-Петербург
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle__inner">
                <div class="header-middle__logo logo">
                    <a class="logo__link" href="{{ url('/') }}">
                        <img class="logo__desc" src="/images/logo3.svg">
                    </a>
                </div>
                <div class="header-middle__menu search">
                    <form class="search__form" action="">
                        <div class="form-cell search__cell">
                            <input class="search__input" type="text">
                            <svg class="search__btnSvg">
                                <use xlink:href="/images/icons.svg#icon_search"></use>
                            </svg>
                            <div class="search__actions">
                                <svg class="js_clear search__close form-cell__cleaner">
                                    <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
                                </svg>
                                <button class="search__submit">Найти</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="header-middle__profile profile yellow">
                    @guest
                        <div class="profile__item js_profile__item">
                            <a class="profile__mlink profile__login" href="{{ route('login') }}">
                                <svg class="profile_svg profile__person-svg">
                                    <use xlink:href="/images/icons.svg#profile-login"></use>
                                </svg>
                                <span class="profile__name">Войти</span>
                            </a>
                        </div>
                        <div class="profile__item js_profile__item">
                            <a class="profile__mlink profile__registr" href="{{ route('register') }}">
                                <svg class="profile_svg profile__person-svg">
                                    <use xlink:href="/images/icons.svg#profile-person"></use>
                                </svg>
                                <span class="profile__name">Регистрация</span>
                            </a>
                        </div>
                        <div class="profile__item">
                            <a class="profile__mlink profile__favorite " href="{{route('favorites_list')}}">
                                <svg class="profile_svg profile__favorite-svg">
                                    <use xlink:href="/images/icons.svg#profile-favorite"></use>
                                </svg>
                                <span class="profile__info">
                                    {{$favoritesCount}}
                                </span>
                                <span class="profile__name">Избранное</span>
                            </a>
                        </div>
                    @else
                        <div class="profile__item js_profile__item">
                            <a class="profile__mlink profile__cabinet" href="{{route('profile.index')}}">
                                <svg class="profile_svg profile__person-svg">
                                    <use xlink:href="/images/icons.svg#profile-person"></use>
                                </svg>
                                <span class="profile__name">Кабинет</span>
                            </a>
                            <div class="js_profile__menu profile-menu">
                                <div class="profile-menu__inner">
                                    <ul class="profile-menu__ul">
                                        <li class="profile-menu__li">
                                            <span class="profile-menu__user">   {{ Auth::user()->name ?? Auth::user()->email}}</span>
                                        </li>
                                        @can('is_admin')
                                            <li class="profile-menu__li">
                                                <a class="profile-menu__link" href="{{ route('admin.index') }}">Админ панель</a>
                                            </li>
                                        @endcan
                                        <li class="profile-menu__li">
                                            <a href="{{route('profile.index')}}" class="profile-menu__link">Ваш кабинет</a>
                                        </li>
                                        <li class="profile-menu__li">
                                            <a href="{{route('profile.ads.index')}}" class="profile-menu__link">Объявления</a>
                                        </li>
                                    </ul>
                                    <ul class="profile-menu__ul">
                                        <li class="profile-menu__li">
                                            <a href="{{route('profile.edit')}}" class="profile-menu__link">Изменить профиль</a>
                                        </li>
                                        <li class="profile-menu__li">
                                            <a href="{{ route('logout') }}" class="profile-menu__link"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                            >Выйти
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="profile__item">
                            <a class="profile__mlink profile__favorite " href="{{route('favorites_list')}}">
                                <svg class="profile_svg profile__favorite-svg">
                                    <use xlink:href="/images/icons.svg#profile-favorite"></use>
                                </svg>
                                <span class="profile__info">
                                    {{$favoritesCount}}
                                </span>
                                <span class="profile__name">Избранное</span>
                            </a>
                        </div>
                        <div class="profile__item js_profile__item">
                            <a class="profile__mlink profile__msg" href="{{route('favorites_list')}}">
                                <svg class="profile_svg profile__favorite-svg">
                                    <use xlink:href="/images/icons.svg#profile-msg"></use>
                                </svg>
                                <span class="profile__name">Уведомления</span>
                            </a>
                            <div class="js_profile__menu profile-menu">
                                <div class="profile-menu__inner">
                                    <ul class="profile-menu__ul">
                                        <li class="profile-menu__li">
                                            <a href="{{route('profile.moderate.index')}}" class="profile-menu__link">
                                                Уведомления
                                                ({{$massagesCounts['moderateCount']}})
                                            </a>
                                        </li>
                                        <li class="profile-menu__li">
                                            <a href="{{route('comments.index')}}" class="profile-menu__link">
                                                Вопросы
                                                ({{$massagesCounts['commentsCount']}})
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @endguest
                </div>
            </div>
        </div>
    </div>

    <div class="header-menus">
        <div class="header-menus__btn"></div>
        <div class="header-menus__menu category-menu">
            <div class="container">
                @widget('menu')
            </div>
        </div>
    </div>
</header>