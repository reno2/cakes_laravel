<div class="advert-line">
    <div class="advert-line__figure">
        @if($ad->getMedia('cover'))
                @if(!empty($ad->getMedia('cover')->first()))
                    <img class="advert-line__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">
                @endif
        @endif
    </div>
    <div class="advert-line__title">
        {{$ad->title}}
    </div>
    <div class="advert-line__category">
        {{$ad->categories->pluck('title')->first()}}
    </div>
    <div class="advert-line__actions">
        <a href="{{route('profile.ads.edit', $ad)}}"><i class="fas fa-edit">изменить</i></a>
        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}"
              action="{{route('profile.ads.destroy', $ad)}}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt">удалить</i></button>
        </form>
    </div>
</div>