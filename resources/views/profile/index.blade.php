@extends('layouts.profile')

@section('content')

    <div class="profile-adverts">
            <div class="container">

            </div>

            <div class="profile-adverts__lines">

                <div id="published" class="js_adsStatusGroups profile-adverts__block active">
                    @if(isset($ads) && !empty($ads))

                        <h4 class="profile-adverts__blockTitle">Опубликованные объявления</h4>
                        <div class="profile-adverts__markup">
                            <div class="profile-adverts__item profile-markup__img">Изображение</div>
                            <div class="profile-adverts__item profile-markup__title">Основное</div>
                            <div class="profile-adverts__item profile-markup__created">Создано</div>
                            <div class="profile-adverts__item profile-markup__updated">Изменено</div>
                            <div class="profile-adverts__item profile-markup__views">Просмотры</div>
                            <div class="profile-adverts__item profile-markup__favorites">Отложено</div>
                            <div class="profile-adverts__item profile-markup__actions">Действия</div>
                        </div>
                        @foreach($ads as $ad)

                            @include('ads.advert__line')
                        @endforeach
                    @else
                        <h4>Объявлений нет</h4>
                    @endif
                </div>
            </div>

        </div>


@endsection
@section('page-script')
    <link rel="stylesheet" href="{{asset('css/b-toggle.css')}}">
@stop