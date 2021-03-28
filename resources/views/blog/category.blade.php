@extends('layouts.app')
{{--{{SeometaFacade::render()}}--}}
{{--@section('title')--}}




{{--@endsection--}}



@section('content')
    @component('chunks.page_title')
        @slot('title') {!! $category->title !!}@endslot
    @endcomponent
{{--    @include('chunks.beadcrumbs')--}}
    <div class="container">
        <div class="row">
{{--          @if(isset($tag))--}}
{{--            {{ Breadcrumbs::render('tag', $tag) }}--}}
{{--            @else--}}
{{--                {{ Breadcrumbs::render('category', $category) }}--}}
{{--            @endif--}}
        </div>
    </div>

    <div class="container">

        <div class="row">
            @forelse($ads as $key => $ad)
                @include('ads.ad')
            @empty
                <div>Никаких объявлений не отложенно</div>
            @endforelse
        </div>
        {{$ads->links()}}
    </div>

@endsection
