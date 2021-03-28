<div class="ad">
    <div class="ad__head">
        @if($ad->getMedia('cover'))
            <div class="ad__mobile">
                @if(!empty($ad->getMedia('cover')->first()))
                    <img class="ad__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">
                @endif
            </div>
            <div class="ad__desktop">
                @forelse($ad->getMedia('cover') as $item)
                    <img class="ad__img" src="{{$item->getUrl('thumb')}}" alt="">
                @empty
                @endforelse
            </div>
        @endif

        <div class="ad__tags">
            @if($ad->tags()->count())
                @foreach($ad->tags()->get()->toArray() as $tag)
                    <div class="ad__tag">
                        <a class="ad__link" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="ad__body">
        <div class="ad__info">
        <div class="ad__categories">
            <a class="ad__category"
               href="{{route('category', $ad->categories->pluck('slug')->first())}}">{{$ad->categories->pluck('title')->first()}}</a>
        </div>
        <h5 class="ad__title">{{$ad->title}}</h5>
        </div>
        <div class="ad__actions">
            <a class="js_modal ad__question gray" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                <i class="fas fa-envelope"></i>
                <span class="ad__ask">&#32 задать вопрос</span>
            </a>


                    <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">
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



        {{--        <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">--}}
        {{--            {{csrf_field()}}--}}
        {{--            <input type="hidden" name="id" value="{{$ad->id}}">--}}
        {{--            <button type="submit" class="btn btn-default">--}}

        {{--                @if(Auth::user() )--}}
        {{--                    @if($favorites && in_array($ad->id, $favorites))--}}
        {{--                        <i class="js_favoritesIcon fas fa-heart"></i>--}}
        {{--                    @else--}}
        {{--                        <i class="js_favoritesIcon far fa-heart"></i>--}}
        {{--                    @endif--}}
        {{--                @else--}}
        {{--                    @if($favorites && in_array($ad->id, $favorites))--}}
        {{--                        <i class="js_favoritesIcon fas fa-heart"></i>--}}
        {{--                    @else--}}
        {{--                        <i class="js_favoritesIcon far fa-heart"></i>--}}
        {{--                    @endif--}}
        {{--                @endif--}}
        {{--            </button>--}}
        {{--        </form>--}}
        {{--        @if($ad->user_id !== Auth::id())--}}
        {{--        <a href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question" class="js_modal">--}}
        {{--            <i class="fas fa-envelope">&#32 задать вопрос</i>--}}
        {{--        </a><br>--}}
        {{--        @endif--}}
        {{--        <a href="{{route('profile.ads.edit', $ad)}}"><i class="fas fa-edit">изменить</i></a>--}}
        {{--        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}"--}}
        {{--              action="{{route('profile.ads.destroy', $ad)}}" method="post">--}}
        {{--            <input type="hidden" name="_method" value="DELETE">--}}
        {{--            {{csrf_field()}}--}}
        {{--            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt">удалить</i></button>--}}
        {{--        </form>--}}
    </div>

</div>
