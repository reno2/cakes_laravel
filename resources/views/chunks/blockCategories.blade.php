
    <div class="categories-block">
        <div class="categories-block__wrap">
            @foreach($categories as $category)
                <a href="{{route('category', $category['slug'])}}" class="categories-block__item">
                    <img src="{{$category->cover}}" alt="" class="categories-block__img">
                    <div class="categories-block__name">{{$category->title}}</div>
                </a>
            @endforeach
        </div>
    </div>
