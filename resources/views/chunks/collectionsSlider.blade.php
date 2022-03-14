

        <!-- Slider main container -->
        <div class="collection js_collection"  style="width:100%">
            <!-- Additional required wrapper -->
            <div class="collection__wrap swiper-wrapper">

                @foreach($collections as $collection)
                    <div class="swiper-slide collection__slide">
                        <a href="{{route('tag', $collection['slug'])}}" class="collection__link">
                            <img class="collection__img" src="{{$collection->cover}}" alt="">
                            <span class="collection__title">{{$collection->title}}</span>
                        </a>
                    </div>

                @endforeach

            </div>

            <div class="collection__prev"></div>
            <div class="collection__next"></div>


        </div>

