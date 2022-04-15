<div class="card ad" style="width: 18rem;">
    <div class="card-image ad__img">
        @if($article->getMedia('cover'))
            <div class="ad__mobile">
                @if(!empty($article->getMedia('cover')->first()))
                    <img class="card-img-top" src="{{$article->getMedia('cover')->first()->getUrl('thumb')}}">
                @endif
            </div>
            <div class="ad__desc">
                @forelse($article->getMedia('cover') as $item)
                    <img class="card-img-top" src="{{$item->getUrl('thumb')}}"
                         alt="Card image cap trt">
                @empty
                @endforelse
            </div>
        @endif

            <div class="ad__tags">
                @if($article->tags()->count())

                        @foreach($article->tags()->get()->toArray() as $tag)
                            <div class="ad__tag">
                            <a class="ad__tag__link" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>
                            </div>
                        @endforeach

                @endif
            </div>
    </div>

    <div class="ad__body card-body">
        <h5 class="ad__title card-title">{{$article->title}}</h5>
        <div class="category a-footer__el">
            Категория: <a
                href="{{route('category', $article->categories->pluck('slug')->first())}}">{{$article->categories->pluck('title')->first()}}</a>
        </div>
        @if (isset($articles->tags))
            <p>Теги:
                @foreach($articles->tags as $tag)
                    {{$tag->name}}
                @endforeach
            </p>
        @endif
        @isset($articles->categories)
            <p>Категории:
                {{$articles->categories->pluck('title')->first()}}
            </p>
        @endisset

        <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$article->id}}">
            <button type="submit" class="btn btn-default">

                @if(Auth::user() )
                    @if($favorites && in_array($article->id, $favorites))
                        <i class="js_favoritesIcon fas fa-heart"></i>
                    @else
                        <i class="js_favoritesIcon far fa-heart"></i>
                    @endif
                @else
                    @if($favorites && in_array($article->id, $favorites))
                        <i class="js_favoritesIcon fas fa-heart"></i>
                    @else
                        <i class="js_favoritesIcon far fa-heart"></i>
                    @endif
                @endif
            </button>
        </form>
        @if($article->user_id !== Auth::id())
        <a href="#" data-user-name="{{$article->user->profiles->first()->name}}" data-ads-id="{{$article->id}}" data-user-id="{{$article->user->id}}" data-modal="feedback__question" class="js_modal">
            <i class="fas fa-envelope">&#32 задать вопрос</i>
        </a><br>
        @endif
        <a href="{{route('profile.ads.edit', $article)}}"><i class="fas fa-edit">изменить</i></a>
        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}"
              action="{{route('profile.ads.destroy', $article)}}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt">удалить</i></button>
        </form>
    </div>
</div>
