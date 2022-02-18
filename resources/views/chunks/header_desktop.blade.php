<div class="header-middle">
    <div class="container">
        <div class="header-middle__inner">
            <div class="header-middle__logo logo">
                <a class="logo__link" href="{{ url('/') }}">
                    <img class="logo__desc" src="/images/full-logo.svg">
                </a>
            </div>
            <div class="header-middle__menu main-menu">
                @widget('moreMenu')

                <div class="search js_search__block">
                    <form class="search__form" action="{{ route('fulltextSearch') }}">
                        <div class="form-cell search__cell">

                            <svg class="js_search__close search__close">
                                <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
                            </svg>

                            <input name="term" placeholder="найти" class="search__input" type="text" value="{{ app('request')->input('term') }}">
                        </div>
                    </form>

                </div>
            </div>





            <div class="header-middle__profile profile">

                <div class="profile__item js_profile__item">
                    <a class="profile__mlink profile__search js_search__open" href="">
                        <svg class="profile_svg profile__person-svg">
                            <use xlink:href="/images/icons.svg#icon_search"></use>
                        </svg>
                        <span class="profile__name">Поиск</span>
                    </a>
                </div>

                @guest
                    <div class="profile__item js_profile__item">
                        <a class="profile__mlink profile__login" href="{{ route('login') }}">
                            <svg class="profile_svg profile__person-svg">
                                <use xlink:href="/images/icons.svg#profile-zamok"></use>
                            </svg>
                            <span class="profile__name">Войти</span>
                        </a>
                    </div>
{{--                    <div class="profile__item js_profile__item">--}}
{{--                        <a class="profile__mlink profile__registr" href="{{ route('register') }}">--}}
{{--                            <svg class="profile_svg profile__person-svg">--}}
{{--                                <use xlink:href="/images/icons.svg#profile-person"></use>--}}
{{--                            </svg>--}}
{{--                            <span class="profile__name">Регистрация</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
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

{{--<div class="header-menus">--}}
{{--    <div class="header-menus__btn"></div>--}}
{{--    <div class="header-menus__menu category-menu">--}}
{{--        <div class="container">--}}
{{--            @widget('menu')--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}