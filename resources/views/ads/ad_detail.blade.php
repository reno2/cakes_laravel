<div class="article-detail">
    <div class="article-detail__head">
        <div class="article-detail__date">
            {{ Date::parse($article->created_at)->format('j F Y г.') }}
        </div>
    </div>
    <div class="article-detail__top">
        
        <div class="article-detail__left article-detail__content">
            
            @if(!$article->getMedia('cover')->isEmpty())
                <div class="article-detail__gallery">
                    <div class="article-detail__block">
                        <div class="article-detail__figure swiper-container">
                            @if(!empty($article->getMedia('cover')))
                                <div class="article-detail__cover swiper-wrapper">
                                    @foreach($article->getMedia('cover') as $cover)
                                        <div class="article-detail__img-wrap swiper-slide">
                                            <img class="article-detail__img"
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
                    <div class="article-detail__nav">
                        <div class="article-detail__navigation swiper-container">
                            @if(!empty($article->getMedia('cover')))
                                <div class="article-detail__thumb swiper-wrapper">
                                    @foreach($article->getMedia('cover') as $cover)
                                        <div class="swiper-slide article-detail__slide">
                                            <img class="article-detail__small"
                                                 src="{{$cover->getUrl('thumb')}}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="article-detail__navigation-arrows swiper__navigate js_swiperNavigate">
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
                </div>
            @else
                <div class="article-detail__placeholder">
                    <img class="article-detail__image full_imgplaceholder" src="{{helper_returnFakeImg('ads_detail')}}" alt="">
                </div>
            @endif

            <div class="article-detail__tags">
                @if($article->tags()->count())
                    <div class="tags">
                        <div class="tags__title">коллекции:</div>
                        <div class="tags__el">
                            @foreach($article->tags()->get()->toArray() as $tag)
                                <a class="tags__item" href="{{route('tag', $tag['slug'])}}">{{$tag['title']}}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="article-detail__bottom">
                <div class="article-detail__subtitle">Характеристки</div>
                <div class="article-detail__block article-features">
                    @if($article->deal_address)
                        <div class="article-features__row">
                            <div class="article-features__name">Вес</div>
                            <div class="article-feature__dote"></div>
                            <div class="article-features__value">{{$article->weight}}</div>
                        </div>
                    @endif
                    @if($article->deal_address)
                        <div class="article-features__row">
                            <div class="article-features__name">Категория товара</div>
                            <div class="article-feature__dote"></div>
                            <div class="article-features__value">
                                <a href="{{route('category', $article->categories->pluck('slug')->first())}}">{{$article->categories->pluck('title')->first()}}</a>
                            </div>
                        </div>
                    @endif
                    @if($article->deal_address)
                        <div class="article-features__row">
                            <div class="article-features__name">Адрес сделки</div>
                            <div class="article-feature__dote"></div>
                            <div class="article-features__value">{{$article->deal_address}}</div>
                        </div>
                    @endif
                    @if($article->deal_address)
                        <div class="article-features__row">
                            <div class="article-features__name">Доставка</div>
                            <div class="article-feature__dote"></div>
                            <div
                                    class="article-features__value">{{($article->delivery_self) ? "доставка возмодна" : "продавец не осуществляет доствку"}}</div>
                        </div>
                    @endif
                </div>

                <div class="article-detail__subtitle">Описание</div>
                <div class="article-detail__block card-block">
                    <div class="article_text article-detail__text">{{$article->description}}</div>
                    <div class="card-block__bottom">
                        <div class="card-block__social">
                            <div class="card-block__social-title">Поделиться:</div>
                            <socialshare title="{{$article->title}}"
                                         desc="{{$article->description}}"
                                         url="{{config('app.url')}}/ads/{{$article->slug}}"
                                         img="
                                    @if(!$article->getMedia('cover')->isEmpty())
                                         {{$article->getMedia('cover')->first()->getUrl('thumb')}}
                                         @else
                                         {{url('storage/images/defaults/cake.svg')}}
                                         @endif
                                                 ">
                            </socialshare>
                        </div>
{{--                        <a class="card-block__report js_modal" href="">сообщить об ошибке</a>--}}
                    </div>
                </div>
            </div>
        </div>



        <div class="article-detail__right">
            <div class="article-detail__form">
                <div class="article-detail__price">
                    <div class="article-detail__amount">
                        {{$article->price}} руб.
                    </div>
                </div>
                @if(!@auth()->check() || (@auth()->check() && (@auth()->user()->id != $article->user_id)))
                    <a class="wide article-detail__ask js_modal__open article__question btn-main btn-big" href="#"
                       data-user-name="{{$article->user->profiles->first()->name}}"
                       data-ads-id="{{$article->id}}" data-user-id="{{$article->user->id}}" data-modal="feedback__question">
                        Написать продавцу
                    </a>
                @endif
                <a class="wide article-detail__phone js_modal btn-secondary btn-big" href="#"
                   data-user-name="{{$article->user->profiles->first()->name}}"
                   data-ads-id="{{$article->id}}" data-user-id="{{$article->user->id}}" data-modal="feedback__question">
                    Показать номер
                </a>
                <div class="article-detail__author article-author">
                    <div class="article-author__ava">
                        <img class="article-author__img" src="{{$article->user->profiles->first()->image ?? helper_returnFakeImg('ads_detail_ava')}}">
                    </div>
                    <div class="article-author__info">
                        <div class="article-author__name">
                            {{$article->user->profiles->first()->name}}
                        </div>
                        <div class="article-author__created">
                            С нами: {{ Date::parse($article->user->profiles->first()->created_at)->format('j F Y г.') }}
                        </div>
                        <div class="article-author__ads">
                            Количество объявлений: {{count($article->user->articles)}}
                        </div>
                    </div>
                </div>
                <div class="article-detail__form__actions">
                    <div class="article-detail__views">
                        <i class="article-detail__views__icon fas fa-eye"></i>
                        <div class="article-detail__views__count">{{views($article)->count()}} просмотры</div>
                    </div>
                    <div class="article-detail__favorites">
                        <form action="{{route('profile.favorites')}}" method="post"
                              class="@if(Auth::user()) auth @else guest @endif js_favorites">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$article->id}}">
                            <button type="submit" class="btn btn-default">

                                @if(Auth::user() )
                                    @if($favorites && in_array($article->id, $favorites))
                                        <svg class="article__favorite js_favoritesIcon profile_svg profile__favorite-svg filled">
                                            <use xlink:href="/images/icons.svg#profile-favorite"></use>
                                        </svg>
                                    @else
                                        <svg class="article__favorite js_favoritesIcon profile_svg profile__favorite-svg">
                                            <use xlink:href="/images/icons.svg#profile-favorite"></use>
                                        </svg>
                                    @endif
                                @else
{{--                                    @if($favorites && in_array($article->id, $favorites))--}}
{{--                                        <svg class="article__favorite js_favoritesIcon profile_svg profile__favorite-svg filled">--}}
{{--                                            <use xlink:href="/images/icons.svg#profile-favorite"></use>--}}
{{--                                        </svg>--}}
{{--                                    @else--}}
{{--                                        <svg class="article__favorite js_favoritesIcon profile_svg profile__favorite-svg">--}}
{{--                                            <use xlink:href="/images/icons.svg#profile-favorite"></use>--}}
{{--                                        </svg>--}}
{{--                                    @endif--}}
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>