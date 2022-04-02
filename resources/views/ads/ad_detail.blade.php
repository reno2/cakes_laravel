<div class="ad-detail">
    <div class="ad-detail__head">
{{--        <div class="ad-detail__title">--}}
{{--            {!! SeometaFacade::getData('h1') !!}--}}
{{--        </div>--}}

        <div class="ad-detail__date">
            {{ Date::parse($ad->created_at)->format('j F Y г.') }}
        </div>
    </div>
    <div class="ad-detail__top">


        <div class="ad-detail__left ad-detail__content">

            <div class="ad-detail__gallery">
                @if(!$ad->getMedia('cover')->isEmpty())
                    <div class="ad-detail__block">
                        <div class="ad-detail__figure swiper-container">
                            @if(!empty($ad->getMedia('cover')))
                                <div class="ad-detail__cover swiper-wrapper">
                                    @foreach($ad->getMedia('cover') as $cover)
                                        <div class="ad-detail__img-wrap swiper-slide">
                                            <img class="ad-detail__img"
                                                 src="{{$cover->getUrl('detail')}}">
                                        </div>
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
                                        <div class="swiper-slide ad-detail__slide">
                                            <img class="ad-detail__small"
                                                 src="{{$cover->getUrl('thumb')}}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="ad-detail__navigation-arrows swiper__navigate js_swiperNavigate">
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
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <img class="full_imgplaceholder" src="{{helper_returnFakeImg()}}" alt="">
                @endif
            </div>
            <div class="ad-detail__tags">
                @if($ad->tags()->count())
                    <div class="tags">
                        <div class="tags__title">коллекции:</div>
                        <div class="tags__el">
                            @foreach($ad->tags()->get()->toArray() as $tag)
                                <a class="tags__item" href="{{route('tag', $tag['title'])}}">{{$tag['title']}}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
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
                    <div class="ad_text ad-detail__text">{{$ad->description}}</div>
                    <div class="card-block__bottom">
                        <div class="card-block__social">
                            <div class="card-block__social-title">Поделиться:</div>
                            <socialshare title="{{$ad->title}}"
                                         desc="{{$ad->description}}"
                                         url="{{config('app.url')}}/ads/{{$ad->slug}}"
                                         img="
                                    @if(!$ad->getMedia('cover')->isEmpty())
                                         {{$ad->getMedia('cover')->first()->getUrl('thumb')}}
                                         @else
                                         {{url('storage/images/defaults/cake.svg')}}
                                         @endif
                                                 ">
                            </socialshare>
                        </div>
                        <a class="card-block__report js_modal" href="">сообщить об ошибке</a>
                    </div>
                </div>
            </div>
        </div>



        <div class="ad-detail__right">
            <div class="ad-detail__form">
                <div class="ad-detail__price">
                    <div class="ad-detail__amount">
                        {{$ad->price}} руб.
                    </div>
                </div>
                @if(!@auth()->check() || (@auth()->check() && (@auth()->user()->id != $ad->user_id)))
                    <a class="wide ad-detail__ask js_modal__open ad__question btn-main btn-big" href="#"
                       data-user-name="{{$ad->user->profiles->first()->name}}"
                       data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                        Написать продавцу
                    </a>
                @endif
                <a class="wide ad-detail__phone js_modal btn-secondary btn-big" href="#"
                   data-user-name="{{$ad->user->profiles->first()->name}}"
                   data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                    Показать номер
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
                                        <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg filled"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                                    @else
                                        <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                                    @endif
                                @else
                                    @if($favorites && in_array($ad->id, $favorites))
                                        <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg filled"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                                    @else
                                        <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
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