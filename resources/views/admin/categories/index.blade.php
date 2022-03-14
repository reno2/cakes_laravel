@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Список категорий @endslot
        @slot('parents') Главная @endslot
        @slot('active') Категории @endslot
    @endcomponent

    <div class="dashboard__create-btn">
        <a class="btn-main btn-big" href="{{route('admin.category.create')}}">Создать категорию</a>
    </div>

    @include('admin.widgets.index_tags', [
                    'heads' => [
                        'id',
                        'Статус',
                        'Дата создания',
                        'Название',
                        'Слаг',
                        'Сорт',
                        'Количество статей',
                        'Изображение',
                        'Действия'
                        ],
                    'values' => $categories,
                    'entity' => 'category'
                    ])

    <ul class="pagination pull-right">
        {{$categories->links()}}
    </ul>
@endsection





