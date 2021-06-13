
@section('content')
    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Материалы'];
    @endphp
    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Создание материала @endslot
        {{--            @slot('parent') Главная @endslot--}}
        @slot('active') Материал @endslot
    @endcomponent

    <div class="create-form">
        <form data-action="{{route('img_add')}}"
              сlass="form-horizontal create-form__form single-img__form"
              action="{{route('admin.settings.store')}}"
              method="post"
              id="post-image">


           <div class="row">

            <div class="col-md-9 create-form__left">
                <div class="create-form__item p-3" id="aform">
                    {{csrf_field()}}
                </div>
            </div>

               <div class="col-md-9 create-form__left">
                   <div class="create-form__item p-3" id="aform">
                       <div class="form-group">
                           <label for="published">Группа настроек</label>
                           <select name="type" class="form-control" id="type">
                               @foreach($types as $key=>$type)
                               <option value="{{$key}}">{{$type}}</option>
                               @endforeach
                           </select>
                       </div>

                       <div class="form-group">
                           <label for="title">Название настройки</label>
                           <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                           @if($errors->has('title'))
                               <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                           @endif
                       </div>
                       <div class="form-group">
                           <label for="value">Значение настройки</label>
                           <textarea name="value" class="form-control" id="value"></textarea>
                           @if($errors->has('value'))
                               <span class="help-block text-danger">{{ $errors->first('value') }}</span>
                           @endif
                       </div>
                       <hr>
                       <div class="form-group">
                           <label for="number">Сортировка</label>
                           <input type="text" name="number" class="form-control" id="number" value="0">
                       </div>
                       <hr>
                       <input type="submit" class="btn btn-block btn-primary" value="Создать запись">
                   </div>
               </div>
           </div>
        </form>
    </div>
@endsection
