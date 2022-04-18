<div class="profile-adverts__markup js_adsWrap" data-id="{{$ad->id}}">
{{--    <div class="advert-line__choose">--}}
{{--        <input type="checkbox" name="ads_choose[]">--}}
{{--    </div>--}}
    <div class="profile-markup__img">
        @if($ad->getMedia('cover'))
            @if(!empty($ad->getMedia('cover')->first()))
                <img class="advert-line__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">
            @else
                <img class="advert-line__img" src="/storage/images/defaults/cake.svg">
            @endif
        @else
            <img class="advert-line__img" src="/storage/images/defaults/cake.svg">
        @endif
    </div>
    <div class="advert-line__item profile-markup__title">
        <div class="advert-line__title"><a class="" href="{{route('profile.ads.edit', $ad)}}">{{$ad->title}}</a></div>
        <div class="advert-line__category">{{$ad->categories->pluck('title')->first()}}</div>
    </div>
    <div class="advert-line__item profile-markup__created">
        {{Carbon\Carbon::parse($ad->created_at)->format('d.m.y')}}
    </div>
    <div class="advert-line__item profile-markup__updated">
        {{Carbon\Carbon::parse($ad->updated_at)->format('d.m.y')}}
    </div>
    <div class="advert-line__item profile-markup__views">
        <div class="advert-line__watches">{{views($ad)->unique()->count()}}</div>
        <div class="advert-line__today"> +{{views($ad)->period(CyrildeWit\EloquentViewable\Support\Period::pastDays(1))->unique()->count()}}</div>
    </div>
    <div class="advert-line__item profile-markup__favorites">
        <div class="advert-line__watches">
            {{$ad->favoritesProfiles->count()}}
        </div>
    </div>

    <div class="profile-markup__actions">
        <div class="t-tooltip js_bToggle">
            <svg class="i-svg i-svg__sm svg_menu b-toggle" data-toggle="b-toggle__content">
                <use xlink:href="{{asset('images/icons.svg#icon-menu')}}"></use>
            </svg>
            <div class="js_bToolContent b-toggle__content">
                @include('chunks.actions_tooltip')
           </div>
        </div>

    </div>
</div>

