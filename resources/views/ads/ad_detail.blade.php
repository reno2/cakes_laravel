<div class="ad-detail">

    <div class="ad-detail__left">
        <div class="ad-detail__figure">
            @if($ad->getMedia('cover'))
                <div class="ad__img">
                    @if(!empty($ad->getMedia('cover')->first()))
                        <img class="ad__img" src="{{$ad->getMedia('cover')->first()->getUrl()}}">
                    @endif
                </div>
            @endif
        </div>
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ad aperiam at consequuntur, iusto maiores quo
            ratione. Consectetur, deleniti, minus. Aspernatur doloremque et, fugiat illum ipsa itaque perferendis quae
            sapiente.
        </div>
        <div>Ad asperiores cum distinctio doloremque error quod sequi vitae. Ab aliquid atque commodi, culpa delectus
            dolor eum ex, in iste minima odio pariatur sequi tempora ut voluptatem? Ex incidunt, quasi.
        </div>
        <div>Ab aliquid blanditiis, delectus dignissimos ducimus ex fugit harum illum iste iure labore magnam minima
            molestiae nam neque nesciunt nulla perferendis quam qui ratione repellendus sapiente sequi unde vel
            voluptas.
        </div>
        <div>Ab atque blanditiis culpa cum delectus dolor dolore exercitationem expedita fugit, ipsum libero natus nemo
            neque non placeat quas quidem repellendus soluta velit, voluptates. Amet atque laboriosam nulla quos
            recusandae?
        </div>
        <div>Excepturi exercitationem nesciunt qui similique voluptas. Aspernatur beatae blanditiis, doloremque dolorum
            esse eveniet expedita libero nobis obcaecati, omnis optio perspiciatis praesentium, recusandae similique
            voluptates! Aut error ipsam molestiae repudiandae voluptatum!
        </div>
        <div>Accusantium adipisci amet architecto aut consequatur cupiditate dolor eveniet fugit illo impedit inventore,
            iure iusto magnam minima, nemo nihil quas quisquam recusandae repudiandae rerum sapiente tempora voluptas
            voluptatibus. Atque, sapiente.
        </div>
        <div>At cum ducimus earum illum in laboriosam quae quia saepe sed ut. Adipisci facilis fugit, odio omnis
            possimus quas voluptatum. Adipisci, dolorem facere id ipsa iure nemo nobis soluta. Amet.
        </div>
        <div>Accusamus ad commodi dicta dolorem earum eos fugit id ipsum iure laboriosam, modi mollitia non nulla,
            officiis quia tempore voluptatem? Aliquid aperiam distinctio, eos id itaque repellat sequi totam voluptate!
        </div>
        <div>Animi consectetur expedita illum minus non nulla officia perferendis porro tempore. Consectetur dicta
            dolor, ducimus eos ex in, libero maiores quae quaerat ratione reprehenderit tempora, tenetur voluptas. Ea,
            laudantium officia.
        </div>
        <div>Accusantium atque corporis doloribus eaque earum, harum nostrum quasi ratione saepe tenetur. Ab cupiditate
            dicta eaque eos ipsa itaque nesciunt nobis, pariatur placeat, qui quibusdam sint. Ipsa quod repellat saepe.
        </div>
    </div>
    <div class="ad-detail__right">
        <div class="ad-detail__main">
            <h5 class="ad-detail__title">{{$ad->title}}</h5>
            <div class="ad-detail__price">
                <div class="ad-detail__amount"><span class="ad-detail__pre">цена</span>{{$ad->price}}</div>
                <i class="ad-detail__symbol fas fa-ruble-sign"></i>
            </div>


            <a class="js_modal ask-question light" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                <i class="fas fa-envelope"></i>
                <span class="ad__ask">&#32 задать вопрос</span>
            </a>
            <a class="js_modal ask-question dark" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">
                <i class="fas fa-phone"></i>
                <span class="ad__ask">показать номер</span>
            </a>

            <div class="ad-detail__author ad-author">
                <div class="ad-author__ava">
                    <img  class="ad-author__img" src="{{Storage::url($ad->user->profiles->first()->image)}}">
                </div>
                <div class="ad-author__info">
                    <div class="ad-author__name">
                        {{$ad->user->profiles->first()->name}}
                    </div>
                    <div class="ad-author__created">
                       С нами: {{$ad->user->profiles->first()->created_at->toFormattedDateString()}}
                    </div>
                    <div class="ad-author__ads">
                       Количество объявлений: {{count($ad->user->articles)}}
                    </div>
                </div>
            </div>

            </div>

        </div>
    </div>
    <div class="ad-detail__bottom">

    </div>
</div>


{{--        @if($ad->getMedia('cover'))--}}
{{--            <div class="ad__mobile">--}}
{{--                @if(!empty($ad->getMedia('cover')->first()))--}}
{{--                    <img class="ad__img" src="{{$ad->getMedia('cover')->first()->getUrl('thumb')}}">--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="ad__desktop">--}}
{{--                @forelse($ad->getMedia('cover') as $item)--}}
{{--                    <img class="ad__img" src="{{$item->getUrl('thumb')}}" alt="">--}}
{{--                @empty--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="ad__tags">--}}
{{--            @if($ad->tags()->count())--}}
{{--                @foreach($ad->tags()->get()->toArray() as $tag)--}}
{{--                    <div class="ad__tag">--}}
{{--                        <a class="ad__link" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="ad__body">--}}
{{--        <div class="ad__info">--}}
{{--            <div class="ad__categories">--}}
{{--                <a class="ad__category"--}}
{{--                   href="{{route('category', $ad->categories->pluck('slug')->first())}}">{{$ad->categories->pluck('title')->first()}}</a>--}}
{{--            </div>--}}
{{--            <h5 class="ad__title">--}}
{{--                <a href="{{route('ads', $ad->slug)}}">--}}
{{--                    {{$ad->title}}</a></h5>--}}
{{--        </div>--}}
{{--        <div class="ad__actions">--}}
{{--            <a class="js_modal ad__question gray" href="#" data-user-name="{{$ad->user->profiles->first()->name}}" data-ads-id="{{$ad->id}}" data-user-id="{{$ad->user->id}}" data-modal="feedback__question">--}}
{{--                <i class="fas fa-envelope"></i>--}}
{{--                <span class="ad__ask">&#32 задать вопрос</span>--}}
{{--            </a>--}}


{{--            <form action="{{route('profile.favorites')}}" method="post" class="@if(Auth::user()) auth @else guest @endif js_favorites">--}}
{{--                {{csrf_field()}}--}}
{{--                <input type="hidden" name="id" value="{{$ad->id}}">--}}
{{--                <button type="submit" class="btn btn-default">--}}

{{--                    @if(Auth::user() )--}}
{{--                        @if($favorites && in_array($ad->id, $favorites))--}}
{{--                            <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>--}}
{{--                        @else--}}
{{--                            <i class="ad__favorite js_favoritesIcon far fa-heart"></i>--}}
{{--                        @endif--}}
{{--                    @else--}}
{{--                        @if($favorites && in_array($ad->id, $favorites))--}}
{{--                            <i class="ad__favorite js_favoritesIcon fas fa-heart"></i>--}}
{{--                        @else--}}
{{--                            <i class="ad__favorite js_favoritesIcon far fa-heart"></i>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}


