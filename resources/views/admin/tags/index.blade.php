@extends('admin.layouts.app_admin')


@section('content')


        @component('admin.components.breadcrumb')
            @slot('title') Список статьи @endslot
            @slot('parents') Главная @endslot
            @slot('active') Теги @endslot
        @endcomponent

        <hr>
            <form action="{{route('admin.tags.store')}}" class="form-inline" method="post">

                <div class="form-group mx-sm-3 mb-2">
                    <input class="form-control" type="text" name="name">
                </div>

{{--                <button type="submit" class="btn btn-primary mb-2">Создать тег</button>--}}
                {{csrf_field()}}
            </form>
        <a href="{{route('admin.tags.create')}}">Создать тег</a>
        <table class="table table-striped">
            <thead>
            <th>Наименование</th>
            <th>Количество статей</th>
            <th class="text-right">Действия</th>
            </thead>
            <tbody>
            @forelse($tags as $article)
                <tr>
                    <td>{{$article->name}}</td>
                    <td>{{$article->articles->count()}}</td>
                    <td align="right">
                        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route('admin.tags.destroy', $article)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
                            <a class="btn btn-default" href="{{route('admin.tags.edit', $article)}}"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-default" href="{{route('admin.tags.show', $article)}}"><i class="fas fa-search"></i></a>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center"><h2>Данные отсутствуют</h2></td>
                </tr>
            @endforelse

            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    <ul class="pagination pull-right">
                        {{$tags->links()}}
                    </ul>
                </td>
            </tr>
            </tfoot>

        </table>



@endsection
