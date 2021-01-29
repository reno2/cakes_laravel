<div class="card ad" style="width: 18rem;">
    <div class="card-image ad__img">
        <a href="#">
            @if($ad->getMedia('cover'))
                @foreach($ad->getMedia('cover') as $item)
                        <img class="card-img-top" src="{{$item->getUrl('thumb')}}"
                     alt="Card image cap"></a>
                   @endforeach
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
        <a href="{{route('profile.ads.edit', $ad)}}"><i class="fas fa-edit">изменить</i></a>
    </div>
</div>
