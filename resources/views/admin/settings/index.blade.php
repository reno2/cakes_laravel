@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Список настроек @endslot
        @slot('parents') Главная @endslot
        @slot('active') Настройки @endslot
    @endcomponent

    <div class="dashboard__create-btn">
        <a class="btn-main btn-big" href="{{route('admin.settings.create')}}">Создать настройку</a>
    </div>



    @include('admin.widgets.index_settings', [
                    'heads' => [
                        'id',
                        'Сорт',
                        'Название',
                        'Описание',
                        'Действия'
                        ],
                    'values' => $settings,
                    'entity' => 'settings'
                    ])

    <ul class="pagination pull-right">
        {{$settings->links()}}
    </ul>





@endsection
