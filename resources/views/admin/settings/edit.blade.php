@section('content')

    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Категории'];
    @endphp
    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Редактирование настройки @endslot
        @slot('active') редактирование @endslot
    @endcomponent
    <div class="create-form">

        <form data-action="{{route('img_add')}}"
              сlass="form-horizontal create-form__form single-img__form"
              action="{{route('admin.settings.update', $parameter)}}" method="POST" id="post-image"
              enctype="multipart/form-data">

            <input type="hidden" name="_method" value="put">
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-9 create-form__left">
                    <div class="create-form__item p-3" id="aform">
                        <div class="form-group">
                            <label for="published">Группа настроек</label>
                            <select name="type" class="form-control" id="type">
                                @foreach($types as $key=>$type)
                                    <option value="{{$key}}" @if($key == $parameter->type) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Название настройки</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{($parameter->title)??old('title')}}">
                            @if($errors->has('title'))
                                <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="value">Значение настройки</label>
                            <textarea name="value" class="form-control" id="value">{{$parameter->value ?? ''}}</textarea>
                            @if($errors->has('value'))
                                <span class="help-block text-danger">{{ $errors->first('value') }}</span>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="number">Сортировка</label>
                            <input type="text" name="number" class="form-control" id="number" value="{{($parameter->number)??old('number')}}">
                        </div>
                        <input type="submit" class="btn btn-block btn-primary" value="Сохранить">
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

