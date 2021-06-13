@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') @if(isset($title))  {{$title}} @else Список статьи @endif @endslot
        @slot('parents') Главная @endslot
        @slot('active') Настройки @endslot
    @endcomponent

    <hr>
    <a href="{{route('admin.settings.create')}}" class="mb-3 btn btn-primary float-md-left">
        <i class="far fa-plus-square"></i>
        Создать параметр
    </a>

    <div class="btn-group float-md-right" role="group" aria-label="Basic example">
        <a href="{{route('admin.article.index', ['sort' => 'asc'])}}" type="button" class="btn btn-secondary">
            <i class="fas fa-sort-amount-down-alt"></i>
        </a>
        <a href="{{route('admin.article.index', ['sort' => 'desc'])}}" type="button" class="btn btn-secondary">
            <i class="fas fa-sort-amount-down"></i>
        </a>
        <a href="{{route('admin.article.index')}}" type="button" class="btn btn-secondary">
            <i class="fas fa-sort-numeric-down"></i>
            Дате добавления
        </a>
    </div>



    <table class="table table-striped">
        <thead>
            <th>#</th>
            <th>Наименование</th>
            <th>Тип</th>
            <th>Сортировка</th>
            <th>Значение</th>
            <th class="text-right">Действия</th>
        </thead>
        <tbody>
            @forelse($settings as $key => $parameter)
                <tr>
                    <td>{{$parameter->id}}</td>
                    <td>{{$parameter->title}}</td>
                    <td>{{$types[$parameter->type]}}</td>
                    <td>{{$parameter->number}}</td>
                    <td>{{$parameter->value}}</td>
                    <td>
                        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route('admin.settings.destroy', $parameter)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <a class="btn btn-default" href="{{route('admin.settings.edit', $parameter)}}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center"><h2>Данные отсутствуют</h2></td>
                </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <ul class="pagination pull-right">
                        {{$settings->links()}}
                    </ul>
                </td>
            </tr>
        </tfoot>

    </table>



@endsection
