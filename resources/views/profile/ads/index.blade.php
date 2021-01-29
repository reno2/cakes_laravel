@extends('layouts.profile')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-start">
                    <a class="btn btn-success" href="{{route("profile.ads.create")}}">Добавить объявление</a>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-start ads">
                    @foreach($ads as $ad)
                        @include('ads.ad')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')
    <link href="{{asset('css/libs/jQuery.Brazzers-Carousel.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/libs/jQuery.Brazzers-Carousel.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".item").brazzersCarousel();
        })
    </script>

@stop
