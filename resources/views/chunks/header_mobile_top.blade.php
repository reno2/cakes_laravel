<div class="m-header__top">

    <div class="mob-top">
        <div class="mob-top__menu js_mobile__menu">
            <svg class="mob-top__svg">
                <use xlink:href="/images/icons.svg#burger-menu5"></use>
            </svg>
            <span class="header-bottom__name"></span>
        </div>

        <form action="{{ route('fulltextSearch') }}" class="mob-top__form">
            <div class="form-cell mob-top__search">
                <input name="term" type="text" value="" class="mob-top__input">
                <button class="btn-unset" type="submit">
                    <svg class="mob-top__svg">
                        <use xlink:href="/images/icons.svg#icon_search"></use>
                    </svg>
                </button>
            </div>

        </form>

    </div>

</div>