@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')


    <div class="profile-adverts">

        <div class="profile-adverts__body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="container">

            </div>
            <div class="container">
                <div class="profile-adverts__switch">
                    <button class="btn-middle blue profile-adverts__link js_adsSwitcher active" data-status="published">Опубликованные</button>
                    <button class="btn-middle blue profile-adverts__link js_adsSwitcher" data-status="not_published">Не опубликованные</button>
                    <button class="btn-middle blue  profile-adverts__link js_adsSwitcher" data-status="moderate">Модерация</button>
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
                    <div id="not_published" class="js_adsStatusGroups profile-adverts__block">
                        @if(isset($adsNotPublished) && !empty($adsNotPublished))
                            <h4 class="profile-adverts__blockTitle">Не опубликованные объявления</h4>
                            <div class="profile-adverts__markup">
                                <div class="profile-adverts__item profile-markup__img">Изображение</div>
                                <div class="profile-adverts__item profile-markup__title">Основное</div>
                                <div class="profile-adverts__item profile-markup__created">Создано</div>
                                <div class="profile-adverts__item profile-markup__updated">Изменено</div>
                                <div class="profile-adverts__item profile-markup__views">Просмотры</div>
                                <div class="profile-adverts__item profile-markup__favorites">Отложено</div>
                                <div class="profile-adverts__item profile-markup__actions">Действия</div>
                            </div>
                            @foreach($adsNotPublished as $ad)
                                @include('ads.advert__line')
                            @endforeach
                        @else
                            <h4>Объявлений нет</h4>
                        @endif
                    </div>
                    <div id="moderate" class="js_adsStatusGroups profile-adverts__block">
                        @if(isset($adsOnModerate) && !empty($adsOnModerate))
                            <h4 class="profile-adverts__blockTitle">Объявления на модерации</h4>
                            <div class="profile-adverts__markup">
                                <div class="profile-adverts__item profile-markup__img">Изображение</div>
                                <div class="profile-adverts__item profile-markup__title">Основное</div>
                                <div class="profile-adverts__item profile-markup__created">Создано</div>
                                <div class="profile-adverts__item profile-markup__updated">Изменено</div>
                                <div class="profile-adverts__item profile-markup__views">Просмотры</div>
                                <div class="profile-adverts__item profile-markup__favorites">Отложено</div>
                                <div class="profile-adverts__item profile-markup__actions">Действия</div>
                            </div>
                            @foreach($adsOnModerate as $ad)
                                @include('ads.advert__line')
                            @endforeach
                        @else
                            <h4>Объявлений нет</h4>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
    <ul class="pagination pull-right">
        {{$ads->links()}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('forms')
    @include('forms.form_delete_ads')
@endsection

@section('page-script')
    <link rel="stylesheet" href="{{asset('css/b-toggle.css')}}">
@stop

