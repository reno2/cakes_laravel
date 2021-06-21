@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') @if(isset($title))  {{$title}} @else Список статьи @endif @endslot
        @slot('parents') Главная @endslot
        @slot('active') Статьи @endslot
    @endcomponent

    <hr>
    <a href="{{route('admin.users.create')}}" class="mb-3 btn btn-primary float-md-left"><i class="far fa-plus-square"></i> Создать материал</a>

    <div class="btn-group float-md-right" role="group" aria-label="Basic example">
        <a href="{{route('admin.users.index', ['sort' => 'asc'])}}" type="button" class="btn btn-secondary"><i class="fas fa-sort-amount-down-alt"></i></a>
        <a href="{{route('admin.users.index', ['sort' => 'desc'])}}" type="button" class="btn btn-secondary"><i class="fas fa-sort-amount-down"></i></a>
{{--        <a href="{{route('admin.users.index')}}" type="button" class="btn btn-secondary"><i class="fas fa-sort-numeric-down"></i> Дате добавления </a>--}}
    </div>



    <table class="table table-striped">
        <thead>
            <th>#</th>
            <th>Наименование</th>
            <th>Почта</th>
            <th>Модерация</th>
            <th>Админ</th>
            <th>Дата создания</th>
            <th class="text-right">Действия</th>

        </thead>
        <tbody>

            @forelse($users as $key => $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->email_verified_at  ?? "Не подтверждён"}}</td>
                    <td>{{($user->is_admin) ? "Да" : "Нет"}}</td>
                    <td>{{Carbon\Carbon::parse($user->created_at)->format('d.m.y H:i')}}</td>
                    <td>
{{--                        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route('admin.user.destroy', $user)}}" method="post">--}}
{{--                            <input type="hidden" name="_method" value="DELETE">--}}
{{--                            {{csrf_field()}}--}}
{{--                            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>--}}
{{--                            <a class="btn btn-default" href="{{route('admin.user.edit', $user)}}"><i class="fas fa-edit"></i></a>--}}
{{--                            <a target="_blank" class="btn btn-default" href="{{route('user', $user->slug)}}"><i class="fas fa-share"></i></a>--}}
{{--                        </form>--}}
                        <a class="btn btn-default" href="{{route('admin.users.edit', $user)}}"><i class="fas fa-edit"></i></a>
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
                        {{$users->links()}}
                    </ul>
                </td>
            </tr>
        </tfoot>

    </table>



@endsection
