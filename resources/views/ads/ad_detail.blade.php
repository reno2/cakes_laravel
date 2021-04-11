<div class="ad-detail">
    <div class="ad-detail__head">
        <div class="ad-detail__title">
            {{$ad->title}}
        </div>
        <div class="ad-detail__date">
            {{ Date::parse($ad->created_at)->format('j F Y г.') }}
        </div>
    </div>
    <div class="ad-detail__top">
        <div class="ad-detail__left">

            <div class="ad-detail__block">
                <div class="ad-detail__figure swiper-container">
                    @if(!empty($ad->getMedia('cover')))
                        <div class="ad-detail__cover swiper-wrapper">
                            @foreach($ad->getMedia('cover') as $cover)
                                <img class="ad-detail__img swiper-slide"
                                     src="{{$cover->getUrl('detail')}}">
                            @endforeach
                        </div>
                        <div class="arrow-big arrow__left">
                            <svg class="arrow-big__direct svg_close">
                                <use xlink:href="{{asset('images/icons.svg#icon-arrow')}}"></use>
                            </svg>
                        </div>
                        <div class="arrow-big arrow__right">
                            <svg class="arrow-big__direct svg_close">
                                <use xlink:href="{{asset('images/icons.svg#icon-arrow')}}"></use>
                            </svg>
                        </div>

                    @endif
                </div>
            </div>
            <div class="ad-detail__nav">
                <div class="ad-detail__navigation swiper-container">
                    @if(!empty($ad->getMedia('cover')))
                        <div class="ad-detail__thumb swiper-wrapper">
                            @foreach($ad->getMedia('cover') as $cover)
                                <img class="ad-detail__small swiper-slide"
                                     src="{{$cover->getUrl('thumb')}}">
                            @endforeach
                        </div>

                        <div class="arrow-big arrow__left">
                            <svg class="arrow-big__direct svg_close">
                                <use xlink:href="{{asset('images/icons.svg#icon-arrow')}}"></use>
                            </svg>
                        </div>
                        <div class="arrow-big arrow__right">
                            <svg class="arrow-big__direct svg_close">
                                <use xlink:href="{{asset('images/icons.svg#icon-arrow')}}"></use>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            @if($ad->tags()->count())
                <div class="tags">
                    <div class="tags__title">теги:</div>
                    <div class="tags__el">
                        @foreach($ad->tags()->get()->toArray() as $tag)
                            <a class="tags__item" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>
                        @endforeach
                    </div>
                </div>
            @endif


        </div>
        <div class="ad-detail__right">
            <div class="ad-detail__form">
                <div class="ad-detail__price">
                    <div class="ad-detail__amount">
                        {{$ad->price}} руб.
                    </div>
                </div>

                <a class="ad-detail__ask js_modal btn-main btn-big" href="#"
                   data-user-name="{{$ad->user->profiles->first()->name}}"
                   data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                    написать продавцу
                </a>
                <a class="ad-detail__phone js_modal btn-second btn-big" href="#"
                   data-user-name="{{$ad->user->profiles->first()->name}}"
                   data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                  показать номер
                </a>
                <div class="ad-detail__author ad-author">
                    <div class="ad-author__ava">
                        <img class="ad-author__img" src="{{$ad->user->profiles->first()->image}}">
                    </div>
                    <div class="ad-author__info">
                        <div class="ad-author__name">
                            {{$ad->user->profiles->first()->name}}
                        </div>
                        <div class="ad-author__created">
                            С нами: {{ Date::parse($ad->user->profiles->first()->created_at)->format('j F Y г.') }}
                        </div>
                        <div class="ad-author__ads">
                            Количество объявлений: {{count($ad->user->articles)}}
                        </div>
                    </div>
                </div>
                <div class="ad-detail__form__actions">
                    <div class="ad-detail__views">
                        <i class="ad-detail__views__icon fas fa-eye"></i>
                        <div class="ad-detail__views__count">{{views($ad)->count()}} просмотры</div>
                    </div>
                    <div class="ad-detail__favorites">
                        <form action="{{route('profile.favorites')}}" method="post"
                              class="@if(Auth::user()) auth @else guest @endif js_favorites">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$ad->id}}">
                            <button type="submit" class="btn btn-default">

                                @if(Auth::user() )
                                    @if($favorites && in_array($ad->id, $favorites))
                                        <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>
                                    @else
                                        <i class="ad__favorite js_favoritesIcon far fa-heart"></i>
                                    @endif
                                @else
                                    @if($favorites && in_array($ad->id, $favorites))
                                        <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>
                                    @else
                                        <i class="ad__favorite js_favoritesIcon far fa-heart"></i>
                                    @endif
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="ad-detail__bottom">

    <div class="ad-detail__subtitle">Характеристки</div>
    <div class="ad-detail__block ad-features">
        @if($ad->deal_address)
            <div class="ad-features__row">
                <div class="ad-features__name">Вес</div>
                <div class="ad-feature__dote"></div>
                <div class="ad-features__value">{{$ad->weight}}</div>
            </div>
        @endif
        @if($ad->deal_address)
            <div class="ad-features__row">
                <div class="ad-features__name">Категория товара</div>
                <div class="ad-feature__dote"></div>
                <div class="ad-features__value">
                    <a href="{{route('category', $ad->categories->pluck('slug')->first())}}">{{$ad->categories->pluck('title')->first()}}</a>
                </div>
            </div>
        @endif
        @if($ad->deal_address)
            <div class="ad-features__row">
                <div class="ad-features__name">Адрес сделки</div>
                <div class="ad-feature__dote"></div>
                <div class="ad-features__value">{{$ad->deal_address}}</div>
            </div>
        @endif
        @if($ad->deal_address)
            <div class="ad-features__row">
                <div class="ad-features__name">Доставка</div>
                <div class="ad-feature__dote"></div>
                <div
                    class="ad-features__value">{{($ad->delivery_self) ? "доставка возмодна" : "продавец не осуществляет доствку"}}</div>
            </div>
        @endif
    </div>

    <div class="ad-detail__subtitle">Описание</div>
    <div class="ad-detail__block card-block">
        {{$ad->description}}
        <div class="card-block__bottom">
            <div class="card-block__social">
                <a target="_blank"
                   href="https://vk.com/share.php?url={{URL::current()}}&title={{$ad->title}}&noparse=true">
                    <i class="fab fa-vk"></i>
                </a>
            </div>

            <a class="card-block__report js_modal" href="">сообщить об ошибке</a>

        </div>
    </div>
</div>

{{--        @if($ad->getMedia('cover'))--}}
{{--            <div class="ad__mobile">--}}
{{--                @if(!empty($ad->getMedia('cover')->first()))--}}
{{--                    <img class="ad__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="ad__desktop">--}}
{{--                @forelse($ad->getMedia('cover') as $item)--}}
{{--                    <img class="ad__img" src="{{$item->getUrl('thumb')}}" alt="">--}}
{{--                @empty--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="ad__tags">--}}
{{--            @if($ad->tags()->count())--}}
{{--                @foreach($ad->tags()->get()->toArray() as $tag)--}}
{{--                    <div class="ad__tag">--}}
{{--                        <a class="ad__link" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="ad__body">--}}
{{--        <div class="ad__info">--}}
{{--            <div class="ad__categories">--}}
{{--                <a class="ad__category"--}}
{{--                   href="{{route('category', $ad->categories->pluck('slug')->first())}}">{{$ad->categories->pluck('title')->first()}}</a>--}}
{{--            </div>--}}
{{--            <h5 class="ad__title">--}}
{{--                <a href="{{route('ads', $ad->slug)}}">--}}
{{--                    {{$ad->title}}</a></h5>--}}
{{--        </div>--}}
{{--        <div class="ad__actions">--}}
{{--            <a class="js_modal ad__question gray" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">--}}
{{--                <i class="fas fa-envelope"></i>--}}
{{--                <span class="ad__ask">&#32 задать вопрос</span>--}}
{{--            </a>--}}


{{--            <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">--}}
{{--                {{csrf_field()}}--}}
{{--                <input type="hidden" name="id" value="{{$ad->id}}">--}}
{{--                <button type="submit" class="btn btn-default">--}}

{{--                    @if(Auth::user() )--}}
{{--                        @if($favorites && in_array($ad->id, $favorites))--}}
{{--                            <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>--}}
{{--                        @else--}}
{{--                            <i class="ad__favorite js_favoritesIcon far fa-heart"></i>--}}
{{--                        @endif--}}
{{--                    @else--}}
{{--                        @if($favorites && in_array($ad->id, $favorites))--}}
{{--                            <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>--}}
{{--                        @else--}}
{{--                            <i class="ad__favorite js_favoritesIcon far fa-heart"></i>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}


