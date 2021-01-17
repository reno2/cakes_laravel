@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Список статьи @endslot
        @slot('parents') Главная @endslot
        @slot('active') Характеристики @endslot
    @endcomponent

    <hr>

    <a href="{{route('admin.features.create')}}" class="mb-3 btn btn-primary float-md-left"><i
            class="far fa-plus-square"></i> Создать материал</a>
    <table class="table table-striped">
        <thead>
        <th>Наименование</th>
        <th>Тип</th>
        <th>Значения</th>
        <th class="text-right">Действия</th>
        </thead>
        <tbody>
        @if($features->isNotEmpty())
            @forelse($features as $feature)

                <tr>
                    <td>{{$feature->title}}</td>
                    <td>{{$feature->type}}</td>
                    <td>
                        @forelse($feature->propertyValues as $fearureValue)
                            <div>{{$fearureValue->value}}</div>
                        @empty

                        @endforelse
                    </td>
                    <td align="right">
                        <form onsubmit="if(confirm('Удалить?')){return true} else {return false}"
                              action="{{route('admin.features.destroy', $feature)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>

                            <a class="btn btn-default" href="{{route('admin.features.edit', $feature->id)}}"><i
                                    class="fas fa-edit"></i></a>
                            <a class="btn btn-default" href="{{route('admin.features.show', $feature)}}"><i
                                    class="fas fa-search"></i></a>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center"><h2>Данные отсутствуют</h2></td>
                </tr>
            @endforelse

        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">
                <ul class="pagination pull-right">
                    {{$features->links()}}
                </ul>
            </td>
        </tr>
        </tfoot>

    </table>



@endsection
