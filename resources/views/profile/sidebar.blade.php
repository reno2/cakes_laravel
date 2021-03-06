<div class="ava">
    <div class="ava__block">
        <img class="ava__img"
             src="{{ (!empty($profile->image)) ? $profile->image:  '/storage/images/avatar/default.svg'}}"
             alt="Card image cap">
    </div>
    <a href="{{route('profile.edit')}}" class="ava__name">{{ $profile->name ?? ''}}
         <svg class="i-svg i-svg__sm i-svg__bgLink"><use xlink:href="/images/icons.svg#icon-edit"></use></svg>
    </a>
</div>

<div class="card personal">
    <div class="card-header">Меню</div>
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
            <span class="badge badge-primary badge-pill">23</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="#">Сообщения</a>
            <span class="badge badge-primary badge-pill">{{$notifications_count}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="personal_a" href="{{route('profile.favorites_list')}}">Избранное</a>
            <span class="badge badge-primary badge-pill">1</span>
        </li>
    </ul>
</div>
