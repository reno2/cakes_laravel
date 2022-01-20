@if(!empty($data))
    <ul class="menu">
        @foreach($data as $value)
            @if(isset($value['CHILDREN']))
                <li class="menu__li @if($value['is_active']) active @endif js_parent menu__parent js_profile__item">
                    <a class="menu__link" href="{{$value['url']}}">
                        {{$value['title']}}
                        <svg class="menu_svg">
                            <use xlink:href="/images/icons.svg#icon_more"></use>
                        </svg>
                    </a>
                    <div class="menu__sub js_menu__sub js_profile__menu ">
                        @include('widgets.menu', ['data' => $value['CHILDREN']])
                    </div>
                </li>
            @else
                <li class="menu__li @if($value['is_active']) active @endif">
                    <a class="menu__link" href="{{$value['url']}}">
                        {{$value['title']}}
                    </a>
                </li>
            @endif

        @endforeach
    </ul>
@endif
