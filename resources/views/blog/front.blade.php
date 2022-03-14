@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection
@section('content')


    @include('chunks.hero')


    <div class="container">
        {{--        {!!  SeometaFacade::getData('h1')  !!}--}}
    </div>

    {{--    @include('chunks.all_massages')--}}
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    @if(count($collections))
        <section class="section section__collections">
            <div class="container">
                <div class="section__title">
                    <div class="section__name">Подборки</div>
                    <div class="section__desc">Десерты на разные праздники, сладости на все случаи жизни.</div>
                </div>
            </div>
            @include('chunks.collectionsSlider')
        </section>
    @endif

    @if(count($categories))
        <section class="section section__collections">
            <div class="container">
                <div class="section__title">
                    <div class="section__name">Категории</div>
                    <div class="section__desc">Не только лишь все могут выбрать себе макарун</div>
                </div>

                @include('chunks.blockCategories')

            </div>
        </section>
    @endif


    @if(count($ads))
        <section class="section section__collections">
            <div class="container">
                <div class="section__title">
                    <div class="section__name">Популярные десерты</div>
                    <div class="section__desc">Без торта и жизнь не та</div>
                </div>

                <div class="ads">
                    @foreach($ads as $ad)
                        @include('ads.ad_front')
                    @endforeach
                </div>

                <ul class="pagination pull-right">
                    {{$ads->links()}}
                </ul>
            </div>
        </section>
    @endif

@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')
    <link href="{{asset('css/libs/jQuery.Brazzers-Carousel.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/libs/jQuery.Brazzers-Carousel.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.ad__desktop').brazzersCarousel();
        });

    </script>
@stop
