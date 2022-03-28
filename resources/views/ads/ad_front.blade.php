<div class="ad">
    <div class="ad__head">
        @if($ad->getMedia('cover'))
            <div class="ad__mobile">
                @if(!empty($ad->getMedia('cover')->first()))

                    <img class="ad__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">
                @else
                    <img class="ad__img" src="/storage/images/defaults/cake.svg">
                @endif
            </div>
            <div class="ad__desktop">
                @forelse($ad->getMedia('cover') as $item)

                    <img class="ad__img" src="{{$item->getUrl('thumb')}}" alt="">
                @empty
                    <img class="ad__img ad__main_placeholder" src="/storage/images/defaults/cake.svg">
                @endforelse
            </div>
        @else

            <div class="ad__mobile">
                <img class="ad__img" src="/storage/images/defaults/cake.svg">
            </div>
        @endif

        @if($ad->tags()->count() && false)
            <div class="ad__tags">
                @foreach($ad->tags()->get()->toArray() as $tag)

                    <div class="ad__tag">
                        <a class="ad__link" href="{{route('tag', $tag['title'])}}">{{$tag['title']}}</a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <div class="ad__body">
        <div class="ad__info">
            <div class="ad__categories">
                <a class="ad__category"
                   href="{{route('category', $ad->categories->pluck('slug')->first())}}">{{$ad->categories->pluck('title')->first()}}</a>
            </div>
            <h5 class="ad__title">
                <a href="{{route('ads', $ad->slug)}}">
                    {{$ad->title}}</a>
            </h5>
        </div>
        <div class="ad__actions">
            @if(!@auth()->check() || (@auth()->check() && (@auth()->user()->id != $ad->user_id)))
                <a class="js_modal__open ad__question btn-small btn-grey" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                    <svg class="ad__svg">
                        <use xlink:href="{{asset('images/icons.svg#icon-message')}}"></use>
                    </svg>
                    <span class="ad__ask">&#32 Задать вопрос</span>
                </a>
            @endif

            @if( ( @auth()->check() && (@auth()->user()->id != $ad->user_id) ) || !@auth()->check())
                <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$ad->id}}">
                    <button type="submit" class="btn btn-unset">
                        @if(Auth::user() )
                            @if($favorites && in_array($ad->id, $favorites))
                                <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg filled"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                            @else
                                <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                            @endif
                        @else
                            @if($favorites && in_array($ad->id, $favorites))
                                <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg filled"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                                <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>
                            @else
                                <svg class="ad__favorite js_favoritesIcon profile_svg profile__favorite-svg"><use xlink:href="/images/icons.svg#profile-favorite"></use></svg>
                            @endif
                        @endif

                    </button>
                </form>
            @endif

        </div>

    </div>

</div>
