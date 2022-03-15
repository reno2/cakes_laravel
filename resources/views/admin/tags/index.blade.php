@extends('admin.layouts.app_admin')


@section('content')

        @component('admin.components.breadcrumb')
            @slot('title') Список тегов @endslot
            @slot('parents') Главная @endslot
            @slot('active') Теги @endslot
        @endcomponent


        <div class="dashboard__create-btn">
            <a class="btn-main btn-big" href="{{route('admin.tags.create')}}">Создать тег</a>
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
                    'values' => $tags,
                    'entity' => 'tags'
                    ])

        <ul class="pagination pull-right">
            {{$tags->links()}}
        </ul>

@endsection
