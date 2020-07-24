<div class="marea-top mtop d-flex marea__item">
    <div class="search mtop-el mr-auto">

        <search-component action="{{URL::route('admin_search', array(), false)}}" autocomplete="{{URL::route('admin_autocomplete', array(), false)}}" place="backend"></search-component>
    </div>
    <div class="mtop-el actions">
        <div class="actions__wrap act-item d-flex align-items-center">
            <div class="actions__el act-item__name">
                <a class="actions__link">
                    <span>{{AUTH::getUser()->name}}</span>
                </a>
            </div>
            <div class="actions__el act-item__wimg">
                <img class="act-item__img" src="{{asset('/images/user.jpg')}}">
            </div>
            <div class="action__el act-item__logout">
                <span>|</span>
                <a class="act-item__link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    выйти
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>