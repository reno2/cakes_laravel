@extends('layouts.app')
@section('content')
    @include('chunks.all_massages')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container">
            <div class="ad-detail">
                @include('ads.ad_detail')
            </div>
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
            $(".ad__desktop").brazzersCarousel();
        })

        // var shareItems = document.querySelectorAll('.social_share');
        // for (var i = 0; i < shareItems.length; i += 1) {
        //     shareItems[i].addEventListener('click', function share(e) {
        //         return JSShare.go(this);
        //     });
        // }

    </script>

@stop
