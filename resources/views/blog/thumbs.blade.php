@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection

@section('content')

    @component('chunks.page_title')
        @slot('title') {!!  SeometaFacade::getData('h1')  !!}@endslot
    @endcomponent

    {{--    @include('chunks.beadcrumbs')--}}
    <section class="section section__breadcrumbs">
        <div class="container">

            @if(isset($tag))
                {{ Breadcrumbs::render('tag', $tag) }}
            @else
                {{ Breadcrumbs::render('category', $category) }}
            @endif

        </div>
    </section>
    <div class="container">

        <div class="ads">
            @forelse($ads as $ad)
                @include('ads.ad_front')
            @empty
                <div>Никаких объявлений не отложенно</div>
            @endforelse
        </div>
        {{$ads->links()}}
    </div>

@endsection