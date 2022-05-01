<div class="m-header__bottom">
    <div class="header-bottom">
        <a class="m-header__logo header-bottom__item" href="/">
            <svg class="header-bottom__svg">
                <use xlink:href="/images/icons.svg#mobile-logo"></use>
            </svg>
            <span class="header-bottom__name">2cakes.ru</span>
        </a>
        @guest

        <a href="/register" class="profile__mlink hero__buy btn-middle-round btn-main">В команду</a>

        <a href="{{ route('login') }}" class="header-bottom__profile header-bottom__item">
            <svg class="header-bottom__svg profile__person-svg">
                <use xlink:href="/images/icons.svg#profile-zamok"></use>
            </svg>
            <span class="header-bottom__name">Войти</span>
        </a>

        @else

        <a href="/favorites" class="header-bottom__messages header-bottom__item">
            <svg class="header-bottom__svg">
                <use xlink:href="/images/icons.svg#profile-msg"></use>
            </svg>
            <span class="header-count">
                {{$noticesDto->getAllCnt()}}
            </span>
            <span class="header-bottom__name">Уведомления</span>
        </a>

        <a href="/favorites" class="header-bottom__favorites header-bottom__item">
            <svg class="header-bottom__svg">
                <use xlink:href="/images/icons.svg#profile-favorite"></use>
            </svg>
            <span class="header-count js_favoritesMain">
                {{$favoritesCount}}
            </span>
            <span class="header-bottom__name">Избранное</span>
        </a>

        <a href="/profile" class="header-bottom__profile header-bottom__item">
            <svg class="header-bottom__svg profile__person-svg">
                <use xlink:href="/images/icons.svg#profile-person"></use>
            </svg>
            <span class="header-bottom__name">Кабинет</span>
        </a>

        @endauth



    </div>
</div>