@section('content')


    <div class="info-cards">
        <div class="info-cards__row">

            @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.settings.index'), 'title' => 'Настройки'];
            @endphp

            @component('admin.components.breadcrumb', ['parents'=>$parents])
                @slot('title') Создание настройку @endslot
                @slot('active') настройка @endslot
            @endcomponent
        </div>
    </div>

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form action="{{route('admin.settings.update', $parameter)}}"
                          method="post"
                          class="dashboard-form create-form">

                        <input type="hidden" name="_method" value="put">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="type" class="form-group__placeholder">Группа настроек</label>
                            <div class="form-group__inputs">
                                <select name="type" class="form-group__select form-control @error('type') is-invalid @enderror" id="type">
                                    @foreach($types as $key=>$type)
                                        <option value="{{$key}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('sort') onError @enderror">Название настройки</label>
                            <div class="form-group__inputs">
                                <input type="text" name="title" class="form-group__input" id="title" value="{{ (old('title')) ?? ($parameter->title) ?? '' }}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row @error('value') onError @enderror">
                            <label for="value" class="form-group__placeholder">Значение настройки</label>
                            <div class="col-md-7 form-group__inputs">
                                <textarea name="value" class="form-group__textarea form-control @error('value') is-invalid @enderror"
                                          id="value">{{ (old('value')) ?? ($parameter->value) ?? '' }}</textarea>
                                @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name" class="form-group__placeholder  @error('sort') onError @enderror">Сортировка</label>
                            <div class="form-group__inputs">
                                <input type="text" name="sort" class="form-group__input" id="name" value="{{ (old('sort')) ?? ($parameter->sort) ?? '' }}">
                                @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <hr>
                        <div class="form-group__actions form-group__single">
                            <div class="offset-md-4 col-md-8">
                                <input type="submit" class="btn-main btn-middle half" value="Создать запись">
                            </div>
                        </div>

                        <input name="image[]" type="file" multiple value=""
                               class="js_fileInput js_file-loader__input js_tag-image file-loader__hidden">

                        <input type="hidden" name="created_by" value="{{Auth::id()}}">




                    </form>
                </div>
            </div>
        </div>
    </div>


    @if(false)

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

    @endif
@endsection

