@extends('admin.layouts.app_admin')


@section('content')

        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.tags.index'), 'title' => 'Теги'];
        @endphp
        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Редактирование тега @endslot
{{--            @slot('parents') Главная @endslot--}}
            @slot('active') редактирование @endslot
        @endcomponent
        <div class="row">
            <div class="col-md-6">

            <form сlass="form-inline" action="{{route('admin.tags.update', $tag)}}">
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" name="title" class="form-control" id="name" value="{{$tag->name or ''}}">
                </div>


                <div class="form-group">
                <input type="submit" class="btn btn-block btn-primary" value="Изменить">
                </div>

                <input type="hidden" name="modified_by" value="{{Auth::id()}}">

            </form>
        </div> </div>



@endsection