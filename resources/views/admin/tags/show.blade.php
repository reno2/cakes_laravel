@extends('admin.layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col-md-6">
            <h3>{{$tag->name}} - тег <small class="text-muted">количество постов с тегом  {{$tag->articles()->count()}}</small></h3>
        </div>
    </div>
    <div class="row">
    <table class="table table-striped">
        <thead>
        <th>Наименование</th>
        <th>Теги</th>
        <th class="text-right">Действия</th>
        </thead>
        <tbody>

        @forelse($tag->articles as $article)
            <tr>
                <td>{{$article->title}}</td>
                <td>
                    @foreach($article->tags as $tag)
                        <span class="badge badge-success">{{$tag->name}}</span>
                    @endforeach
                </td>
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

                </ul>
            </td>
        </tr>
        </tfoot>

    </table>

@endsection