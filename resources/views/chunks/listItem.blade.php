<div class="my-3 mx-2 card" style="width: 30%;">


    <img src="{{$article->categories->pluck('image')->first()}}">
    <div class="card-body">
        @include('chunks.check_admin')
        <h5 class="card-title"><a href="{{route('article', $article->slug)}}">{{$article->title}}</a></h5>
        <div class="cart-category">

            <a  class="cart-category__el" href="/blog/category/{{$article->categories->pluck('slug')->first()}}">
                <i class="fas fa-folder-open"></i> &nbsp; {{$article->categories->pluck('title')->first()}}
            </a>
            <span class="cart-category__el">
                <span class="cart-category__date">{{Carbon\Carbon::parse($article->created_at)->format('d.m.y H:i')}}</span>
            </span>
        </div>

        <p class="card-text f-gilroy">{!! $article->description_short !!}</p>
        <div class="card-footer bg-transparent">
            <div class="tags">

                @foreach($article->tags()->get()->toArray() as $tag)
                    <a class="tags__item" href="{{route('tag', $tag['name'])}}">{{$tag['name']}}</a>
                @endforeach

            </div>
        </div>

    </div>
</div>


