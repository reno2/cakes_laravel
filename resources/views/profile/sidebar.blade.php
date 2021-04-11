<div class="ava">
    <div class="ava__block">
        <img class="ava__img"
             src="{{ (!empty($profile->image)) ? $profile->image :  '/storage/images/avatar/default.svg'}}"
             alt="Card image cap">
    </div>

</div>
<a href="{{route('profile.edit')}}" class="ava__name">{{ $profile->name ?? ''}}
    <svg class="i-svg i-svg__sm i-svg__bgLink"><use xlink:href="/images/icons.svg#icon-edit"></use></svg>
</a>
<div class="card personal">
    <div class="card-header">Меню - {{Auth::id()}}</div>
    <ul class="list-group list-group-flush personal_ul">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('profile.edit')}}">
                <svg class="i-svg i-svg__md i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-personal-data"></use></svg>
                <span>Изменить профиль</span>
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('profile.secure')}}">
                <svg class="i-svg i-svg__md i-svg__bgDark"><use xlink:href="/images/icons.svg#icon-personal-shield"></use></svg>
                <span>Изменить пароль</span>
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('profile.ads.index')}}">Объявления</a>
            <span class="info-badge blue">23</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('comments.index')}}">Вопросы</a>
            <span class="info-badge blue">{{$commentsCount}}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('profile.favorites_list')}}">Избранное</a>
            <span class="info-badge blue">{{$favorites}}</span>
        </li>
    </ul>
</div>
