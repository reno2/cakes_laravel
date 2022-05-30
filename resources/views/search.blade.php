@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection
@section('content')

    <div class="container">
        {!!  SeometaFacade::getData('h1')  !!}
    </div>

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif


        <div class="container">
            <div class="ads">

                @forelse($items as $ad)
                    @include('ads.ad_front')
                @empty
                    <div>Никаких объявлений не найдено</div>
                @endforelse
            </div>
        </div>
    </div>
    <ul class="pagination pull-right">
{{--        {{$ads->links()}}--}}
    </ul>
@endsection
