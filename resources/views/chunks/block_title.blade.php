{{--    @include('chunks.beadcrumbs')--}}

<section class="block-title">
    <div class="container">

        <div class="block-title__breadcrumbs">
            @if(isset($tag))
                {{ Breadcrumbs::render('tag', $tag) }}
            @endif

            @if(isset($category))
                {{ Breadcrumbs::render('category', $category) }}
            @endif

            @if(isset($article))
                {{ Breadcrumbs::render('article', $article->categories()->first(), $article) }}
            @endif
        </div>

        <div class="block-title__title">
            {!! SeometaFacade::getData('h1') !!}
        </div>

    </div>
</section>

