@extends('layouts.app')

@section('content')


    @include('chunks.all_massages')






            <div class="container">
                <div class="row justify-content-start ads">

                    @forelse($ads as $key => $ad)
                        @include('ads.ad')
                    @empty
                        <div>Никаких объявлений не отложенно</div>
                    @endforelse
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

