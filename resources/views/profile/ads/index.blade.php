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

{{--                    <div class="profile-adverts__info">--}}
{{--                        <div class="profile-adverts__item profile-adverts__img">изображение</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__title">основное</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__created">создание</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__updated">изменение</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__views">просмотры</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__favorites">отложено</div>--}}
{{--                        <div class="profile-adverts__item profile-adverts__actions">действия</div>--}}
{{--                    </div>--}}
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
@include('forms.form_delete_ads')
@section('page-script')
    <link rel="stylesheet" href="{{asset('css/b-toggle.css')}}">
@stop

