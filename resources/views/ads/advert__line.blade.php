<div class="advert-line">
    <div class="advert-line__figure">
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
    <div class="advert-line__item advert-line__main">
        <div class="advert-line__title">{{$ad->title}}</div>
        <div class="advert-line__category">{{$ad->categories->pluck('title')->first()}}</div>
    </div>
    <div class="advert-line__item advert-line__created">
        {{Carbon\Carbon::parse($ad->created_at)->format('d.m.y H:i')}}
    </div>
    <div class="advert-line__item advert-line__updated">
        {{Carbon\Carbon::parse($ad->updated_at)->format('d.m.y H:i')}}
    </div>
    <div class="advert-line__item advert-line__views">
        <div class="advert-line__watches">{{views($ad)->unique()->count()}}</div>
        <div class="advert-line__today"> +{{views($ad)->period(CyrildeWit\EloquentViewable\Support\Period::pastDays(1))->unique()->count()}}</div>
    </div>
    <div class="advert-line__item advert-line__favorites">
        <div class="advert-line__watches">
            {{$ad->favoritesProfiles->count()}}
        </div>
    </div>

    <div class="advert-line__actions">
        <div class="t-tooltip">

            <svg class="i-svg i-svg__sm svg_menu b-toggle js_bToggle" data-toggle="b-toggle__content">
                <use xlink:href="{{asset('images/icons.svg#icon-menu')}}"></use>
            </svg>

            <div class="js_bToolContent b-toggle__content">
                @include('chunks.actions_tooltip')
            </div>
        </div>

    </div>
</div>

