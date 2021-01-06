
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
              action="{{route('admin.article.store')}}"
              method="post"
              enctype="multipart/form-data"
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
                           <label for="published">Статус</label>
                           <select name="published" class="form-control" id="published">
                               <option value="0">Не опубликовано</option>
                               <option value="1">Опубликовано</option>
                           </select>
                       </div>

                       <div class="form-group form-check">
                           <input type="checkbox"  name="on_front" class="form-check-input" id="exampleCheck1">
                           <label class="form-check-label" for="exampleCheck1">Показывать на главной</label>
                       </div>

                       <div class="form-group">
                           <label for="title">Заголовок</label>
                           <input type="text" name="title" class="form-control" id="name" value="{{ old('title') }}">
                           @if($errors->has('title'))
                               <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                           @endif
                       </div>

                       <div class="form-group">
                           <label for="title">Сортировка</label>
                           <input type="text" name="sort" class="form-control" id="sort" value="">
                       </div>

                       <div class="form-group">
                           <label for="title">Стоимость Руб.</label>
                           <input type="text" name="price" class="form-control" id="price" value="">
                       </div>
                       <div class="form-group">
                           <label for="title">Вес. г</label>
                           <input type="text" name="weight" class="form-control" id="weight" value="">
                       </div>


                       <div class="slug d-flex align-items-center">
                           <div class="form-group slug__el" id="slug__toggle">
                               <input type="text" name="slug" class="form-control" id="slug" value="" readonly>
                           </div>
                           <div class="form-group slug__el form-check slug__checkbox ml-3">
                               <input type="checkbox" name="slug__change" class="form-check-input" id="slug__change">
                               <label class="form-check-label" for="slug__change">Задать slug</label>
                           </div>
                       </div>


                       <div class="form-group">
                           <label for="">Теги</label>
                           <select multiple="" name="tags[]" id="tags">
                               @foreach($tags as $tag)
                                   <option value="{{$tag->id}}">{{$tag->name}}</option>
                               @endforeach
                           </select>
                       </div>

                       <div class="form-group">
                           <label for="">Краткое описание</label>
                           <textarea name="description_short" class="form-control" id="description_short"></textarea>
                       </div>

                       <div class="form-group">
                           <label for="">Описание</label>
                           <textarea name="description" class="form-control" id="description"></textarea>
                       </div>

                       <div class="form-group">
                           <label for="title">Мета-Заголовок</label>
                           <input type="text" name="meta_title" class="form-control" id="meta_title" value="">
                       </div>

                       <div class="form-group">
                           <label for="title">Мета-Описание</label>
                           <input type="text" name="meta_description" class="form-control" id="meta_description" value="">
                       </div>

                       <div class="form-group">
                           <label for="categories">Родительская категория</label>
                           <select name="categories[]" class="form-control" id="categories" multiple>
                               <option value="0">-- без родителей</option>
                               @include('admin.articles.partials.categories', ['categories' => $categories, ])
                           </select>
                       </div>

                       <div class="form-group">
                           <div id="product-filters">Фильтры продукта</div>
                           {{--Widgets::filter tpl--}}
                           @if(isset($filter))
                               @widget('articleCreate', ['tpl'=>'Widgets::adminFiltersGroup', 'filter' => $filter])
                           @else
                               @widget('articleCreate', ['tpl'=>'Widgets::adminFiltersGroup', 'filter' => null])
                           @endif
                       </div>

                       <div class="form-check form-reload">
                           <input type="checkbox" value="" checked name="reload" class="form-check-input" id="reload">
                           <label class="form-check-label" for="reload">Не возвращатся к списку</label>
                       </div>
                       <hr>
                       <input type="submit" class="btn btn-block btn-primary" value="Создать запись">
                       <input type="hidden" name="modified_by" value="{{Auth::id()}}">
                   </div>
               </div>
               <div class="col-md-3 p-0 create-form__right">
                   <div class="js_postUpMsg post-up__msg"></div>
                   <div class="p-3 create-form__item single-img">
                       <div class="create-form__title">Основная картинка<br>
                           Загрузите свои изображения<br>
                           не более 5 файлов. (jpeg, png)
                       </div>
                       <div class="form-group single-img__group">
                           <input multiple name="image[]" type="file" id="file_" value=""
                                  data-count="0" class="single-img__input">
                           <div class="create-form__error"></div>
                       </div>
                   </div>
                   <input type="hidden" name="main_image" id="main_image">
                   <div id="image-list" class="create-form__preview image-preview">
                       <div class="fake-upload">
                           <img class="fake-upload__img" src="{{ asset('images/file-upload3.svg') }}" alt="">
                       </div>
                   </div>

               </div>
           </div>
        </form>
    </div>
@endsection
