@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')


    <div class="ui-card">
        <div class="ui-card__body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-start ads thirdWidth">
                    @forelse($ads as $key => $ad)
                        @include('ads.ad_front')
                    @empty
                        <div>Никаких объявлений не отложенно</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <ul class="pagination pull-right">
        {{$ads->links()}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')
    <link href="{{asset('css/libs/jQuery.Brazzers-Carousel.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/libs/jQuery.Brazzers-Carousel.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".ad__desc").brazzersCarousel();
        })
    </script>
@stop

