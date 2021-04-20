@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')


    <div class="profile-adverts">
        <div class="profile-adverts__header">{{ __('Dashboard') }}</div>
        <div class="profile-adverts__body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="container">
                <div class="profile-adverts__actions">
                    <a class="btn btn-success" href="{{route("profile.ads.create")}}">Добавить объявление</a>
                </div>
            </div>
            <div class="container">
                <div class="profile-adverts__lines">
                    @foreach($ads as $ad)
                        @include('ads.advert__line')
                    @endforeach
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

