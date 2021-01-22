<div class="card ad" style="width: 18rem;">
    <div class="card-image ad__img">
        <a href="#">
            <img class="card-img-top" src="{{$article->images->first()['small']}}"
                 alt="Card image cap"></a>
    </div>

    <div class="ad__body card-body">
        <h5 class="ad__title card-title">{{$ad->title}}</h5>
        <p class="ad__desc card-text">
            Описание: {{$article->description}}</p>
        <p>Теги:
            @foreach($article->tags as $tag)
                {{$tag->name}}
            @endforeach
        </p>
        <p>Категории:
            {{$article->categories->pluck('title')->first()}}
        </p>
        <a href="{{route('profile.ads.edit', $article)}}"><i class="fas fa-edit">изменить</i></a>
    </div>
</div>
