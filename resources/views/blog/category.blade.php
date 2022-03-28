@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection

@section('content')

    @include('chunks.block_title', compact($category))

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
