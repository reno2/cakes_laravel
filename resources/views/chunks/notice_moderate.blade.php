<div class="notification__count">
    {{--    Всего уведомлений: {{$notifications->count()}}--}}
</div>
@forelse($notifications as $notification)

    <div class="notification js_notificationItem">
        <div class="notification__content">
            <div class="notification__figure">
                <a class="notification__link-edit" href="{{$notification['data']['link']}}">
                    <img class="notification__img" src="{{$notification['data']['img']}}">
                </a>
            </div>
            <div class="notification__info">
                <div class="notification__message">
                    <div class="notification__date">
                        [{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->toFormattedDateString()}}] -
                        @if(isset($notification->data['moderate']) && $notification->data['moderate'])
                            <span class="notification__status notification__status_good">{{$notification->data['title']}} </span>
                        @else
                            <span class="notification__status notification__status_bad">{{$notification->data['title']}} </span>
                        @endif
                    </div>
                    <div class="notification__ads">{{$notification->data['ads']['title'] ?? $notification->data['ads']}}</div>
                    @if(count($notification['data']))
                        <div class="notification__data toggle-block js_toggleBlock">


                            <div class="js_toggleBlockContent toggle-block__content" data-max-height="20">

                                @isset($notification->data['message'])
                                    <div class="notification__admin">Комментарий:</div>
                                @endisset
                                <div class="notification__body">
                                    @isset($notification->data['message'])
                                        <div class="notification__mess">
                                            {{$notification->data['message']}}
                                        </div>
                                    @endisset

                                    @isset($notification->data['rules'])
                                        @isset($notification->data['rules'])
                                            <div class="notification__admin">Нарушенны правила:</div>
                                        @endisset
                                        <ul class="notification__rules">
                                            @foreach($notification->data['rules'] as $key => $rule)
                                                <li>{{$rule}}</li>
                                            @endforeach
                                        </ul>
                                    @endisset
                                </div>
                            </div>

                            <div class="toggle-block__gradient"></div>
                            <div class="js_toggleBlockToggler toggle-block__btn">
                                <div class="js_toggleBlockText toggle-block__text" data-text="Скрыть">Далее</div>
                                <svg class="toggle-block__svg">
                                    <use xlink:href="/images/icons.svg#icon-more"></use>
                                </svg>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="notification__link">
                    <a href="#" class="btn-middle blue float-right mark-as-read js_makeAsRead" data-id="{{ $notification['id'] }}" data-user="{{Auth::id()}}">
                        Прочитать
                    </a>
                </div>
                {{--            <a href="/profile/comments/{{ $notification->data['all']['article_id']}}/{{ $notification->data['all']['from_user_id'] }}">{{ $notification->data['advert'] }}</a>  был задан вопрос.--}}

            </div>
        </div>
    </div>
@empty
    <div class="no-results">
        <div class="no-results__figure">
            <svg class="no-results__icon">
                <use xlink:href="/images/icons.svg#icon-notification_empty"></use>
            </svg>
        </div>
        <div class="no-results__title">У вас нет уведимлений</div>
    </div>
@endforelse
<div class="notification__bottom">
    <div class="notification__pagination">
        {{ $notifications->links() }}
    </div>
</div>
