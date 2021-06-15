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
                <div class="profile-adverts__switch">
                    <button class="btn-middle blue profile-adverts__link js_adsSwitcher active" data-status="published">Опубликованные</button>
                    <button class="btn-middle blue profile-adverts__link js_adsSwitcher" data-status="not_published">Не опубликованные</button>
                    <button class="btn-middle blue  profile-adverts__link js_adsSwitcher" data-status="moderate">Модерация</button>
                </div>
                <div class="profile-adverts__lines">

                    <div id="published" class="js_adsStatusGroups profile-adverts__block active">
                        @if(isset($ads) && !empty($ads))

                            <h4 class="profile-adverts__blockTitle">Опубликованные объявления</h4>

                            <table cellpadding="16" class="profile-adverts__info">
                                <tr>
                                    <td class="profile-adverts__item profile-adverts__img">Изображение</td>
                                    <td class="profile-adverts__item profile-adverts__title">Основное</td>
                                    <td class="profile-adverts__item profile-adverts__created">Создано</td>
                                    <td class="profile-adverts__item profile-adverts__updated">Изменено</td>
                                    <td class="profile-adverts__item profile-adverts__views">Просмотры</td>
                                    <td class="profile-adverts__item profile-adverts__favorites">Отложено</td>
                                    <td class="profile-adverts__item profile-adverts__actions">Действия</td>
                                </tr>
                            </table>
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
                            <table cellpadding="16" class="profile-adverts__info">
                                <tr>
                                    <td class="profile-adverts__item profile-adverts__img">Изображение</td>
                                    <td class="profile-adverts__item profile-adverts__title">Основное</td>
                                    <td class="profile-adverts__item profile-adverts__created">Создано</td>
                                    <td class="profile-adverts__item profile-adverts__updated">Изменено</td>
                                    <td class="profile-adverts__item profile-adverts__views">Просмотры</td>
                                    <td class="profile-adverts__item profile-adverts__favorites">Отложено</td>
                                    <td class="profile-adverts__item profile-adverts__actions">Действия</td>
                                </tr>
                            </table>
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
                            <table cellpadding="16" class="profile-adverts__info">
                                <tr>
                                    <td class="profile-adverts__item profile-adverts__img">Изображение</td>
                                    <td class="profile-adverts__item profile-adverts__title">Основное</td>
                                    <td class="profile-adverts__item profile-adverts__created">Создано</td>
                                    <td class="profile-adverts__item profile-adverts__updated">Изменено</td>
                                    <td class="profile-adverts__item profile-adverts__views">Просмотры</td>
                                    <td class="profile-adverts__item profile-adverts__favorites">Отложено</td>
                                    <td class="profile-adverts__item profile-adverts__actions">Действия</td>
                                </tr>
                            </table>
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

