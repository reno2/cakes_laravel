<div class="card ad" style="width: 18rem;">
    <div class="card-image ad__img">
        @if($ad->getMedia('cover'))
            <div class="ad__mobile">
                @if(!empty($ad->getMedia('cover')->first()))
                <img class="card-img-top" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">
                @endif
            </div>
            <div class="ad__desc">
                @forelse($ad->getMedia('cover') as $item)
                    <img class="card-img-top" src="{{$item->getUrl('thumb')}}"
                         alt="Card image cap trt">
                @empty
                @endforelse
            </div>
        @endif
    </div>

    <div class="ad__body card-body">
        <h5 class="ad__title card-title">{{$ad->title}}</h5>
        <p class="ad__desc card-text">
            Описание: </p>
        @if (isset($ads->tags))
            <p>Теги:
                @foreach($ads->tags as $tag)
                    {{$tag->name}}
                @endforeach
            </p>
        @endif
        @isset($ads->categories)
            <p>Категории:
                {{$ads->categories->pluck('title')->first()}}
            </p>
        @endisset

        <form action="{{route('profile.favorites')}}" method="post" class="js_favorites">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$ad->id}}">
            <button type="submit" class="btn btn-default">
                @if($favorites && in_array($ad->id, $favorites))
                    <i class="js_favoritesIcon fas fa-heart"></i>
                @else
                    <i class="js_favoritesIcon far fa-heart"></i>
                @endif
            </button>
        </form>



        <a href="{{route('profile.ads.edit', $ad)}}"><i class="fas fa-edit">изменить</i></a>
        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route('profile.ads.destroy', $ad)}}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt">удалить</i></button>
        </form>
    </div>
</div>
