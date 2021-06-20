<div class="ava">
    <div class="ava__block">
        <img class="ava__img js_profileAva"
             src="{{($profile->image) ? $profile->image.'?v='.\Carbon\Carbon::parse($profile->updated_at)->timestamp :  '/storage/images/defaults/cake.svg'}}">
    </div>

</div>

    <div class="ui-menu__li ava__name ui-menu__accent">
        <a class="" href="{{route("profile.ads.create")}}">
            <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-add"></use></svg>
            <span class="ui-menu__text">Добавить объявление</span>
        </a>
    </div>



<a href="{{route('profile.edit')}}" class="ui-menu__li ava__name">{{ $profile->name ?? ''}}
    <svg class="i-svg i-svg__sm i-svg__bgLink"><use xlink:href="/images/icons.svg#icon-edit"></use></svg>
</a>
<div class="ui-block">
    <ul class="ui-block__menu profile-menu">
        <li class="ui-menu__li">
            <a class="personal_a" href="{{route('profile.edit')}}">
                <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-profile"></use></svg>
                <span class="ui-menu__text">Изменить профиль</span>
            </a>
        </li>
        <li class="ui-menu__li">
            <a class="personal_a" href="{{route('profile.secure')}}">
                <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-pass"></use></svg>
                <span class="ui-menu__text">Изменить пароль</span>
            </a>
        </li>
        <li class="ui-menu__li">
            <a class="personal_a" href="{{route('profile.ads.index')}}">
                <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-ads"></use></svg>
                <span class="ui-menu__text"> Объявления</span>
            </a>
            <span class="info-badge blue">23</span>
        </li>
        <li class="ui-menu__li">
            <a class="personal_a" href="{{route('comments.index')}}">
                <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-questions"></use></svg>
                <span class="ui-menu__text">Вопросы</span>
            </a>
            <span class="info-badge blue">{{$commentsCount}}</span>
        </li>

        <li class="ui-menu__li">
            <a class="personal_a" href="{{route('profile.favorites_list')}}">
                <svg class="i-svg i-svg__tw i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-favorites"></use></svg>
                <span class="ui-menu__text">Избранное</span>
            </a>
            <span class="info-badge blue">{{$favorites}}</span>
        </li>
    </ul>
</div>
