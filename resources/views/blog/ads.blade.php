@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection
@section('content')
    @include('chunks.all_massages')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="container">
        <div class="ad-detail">
            @include('ads.ad_detail')
        </div>
    </div>

@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')
    {{--    <script src="{{asset('js/jsshare.js')}}"></script>--}}
    <link href="{{asset('css/libs/jQuery.Brazzers-Carousel.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/libs/jQuery.Brazzers-Carousel.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.ad__desktop').brazzersCarousel();
        });

    </script>

@stop
