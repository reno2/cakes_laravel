<div class="card ad" style="width: 18rem;">
    <div class="card-image ad__img">
        <a href="#">
            <img class="card-img-top" src="{{$ad->images->first()['small']}}"
                 alt="Card image cap"></a>
    </div>

    <div class="ad__body card-body">
        <h5 class="ad__title card-title">{{$ad->title}}</h5>
        <p class="ad__desc card-text">
            Описание: {{$ad->description}}</p>
        <p>Теги:
            @foreach($ad->tags as $tag)
                {{$tag->name}}
            @endforeach
        </p>
        <p>Категории:
            {{$ad->categories->pluck('title')->first()}}
        </p>
    </div>
</div>
