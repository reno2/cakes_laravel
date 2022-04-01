<div class="b-tooltip__links">

    <a class="b-tooltip__link" href="{{route('profile.ads.edit', $ad)}}">
        <i class="fas fa-pen"></i>
        <span class="b-tooltip__name">изменить</span>
    </a>
    <form class="widget__actions" onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route("profile.ads.destroy", $ad)}}" method="post">
        <input type="hidden" name="_method" value="DELETE">
        {{csrf_field()}}
        <button type="submit" class="b-tooltip__link" href="#" data-modal="confirm_delete" data-id="{{$ad->id}}" data-url="{{route('profile.ads.destroy', $ad)}}">
        <i class="fas fa-trash"></i>
        <span class="b-tooltip__name">удалить</span>
        </button>
    </form>

    <a class="b-tooltip__link js_postUp" data-id="{{$ad->id}}" href="">
        <i class="fas fa-redo"></i>
        <span class="b-tooltip__name">Поднять</span>
    </a>



</div>



{{--<button data-id="5" class="js_postUp btn btn-success btn-block post-update mb-3">--}}
{{--    Поднять--}}
{{--</button>--}}