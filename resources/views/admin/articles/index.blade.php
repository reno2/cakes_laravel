@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') @if(isset($title))  {{$title}} @else Список объявлений @endif @endslot
        @slot('parents') Главная @endslot
        @slot('active') Объявления @endslot
    @endcomponent

    <div class="dashboard__create-btn">
        <a class="btn-main btn-big" href="{{route('admin.article.create')}}">Создать объявление</a>
    </div>




    @include('admin.components.sort')

    @include('admin.widgets.index_ads', [
                'heads' => [
                'id',
                'Статус',
                'Дата соз.',
                'Сорт',
                'Модер.',
                'На главной',
                'Автор',
                'Название',
                'Слаг',
                'Теги',
                'Категории',
                'Картинка',
                'Действия'
                ],
                'values' => $articles,
                'entity' => 'article'
                ])


    <ul class="pagination pull-right">
        {{$articles->appends(Request::query())->render()}}
    </ul>

@endsection
