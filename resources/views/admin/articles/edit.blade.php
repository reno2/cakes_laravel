@section('content')

    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Категории'];
    @endphp
    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Редактирование материала @endslot
        {{--            @slot('parents') Главная @endslot--}}
        @slot('active') редактирование @endslot
    @endcomponent
    <div class="create-form">

        <form data-action="{{route('img_add')}}"
              сlass="form-horizontal create-form__form single-img__form"
              action="{{route('admin.article.update', $article)}}" method="POST" id="post-image"
              enctype="multipart/form-data">

            <input type="hidden" name="_method" value="put">
            {!!csrf_field()!!}
            <div class="row">
                <div class="col-md-9 create-form__left">
                    <div class="create-form__item p-3" id="aform">
                        <div class="form-group">
                            <label for="published">Статус</label>
                            <select name="published" class="form-control" id="published">
                                <option value="0" @if($article->published == 0) selected="" @endif>Не опубликовано
                                </option>
                                <option value="1" @if($article->published == 1) selected="" @endif>Опубликовано</option>
                            </select>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" @if(isset($article->on_front) && $article->on_front == true) checked
                                   @endif  name="on_front" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Показывать на главной</label>
                        </div>

                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" name="title" class="form-control" id="name"
                                   value="{{($article->title)??old('title')}}">
                            @if($errors->has('title'))
                                <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="title">Сортировка</label>
                            <input type="text" name="sort" class="form-control" id="sort"
                                   value="{{$article->sort ?? ''}}">
                        </div>

                        <div class="form-group">
                            <label for="title">Стоимость Руб.</label>
                            <input type="text" name="price" class="form-control" id="price"
                                   value="{{$article->price ?? ''}}">
                        </div>
                        <div class="form-group">
                            <label for="title">Вес. г</label>
                            <input type="text" name="weight" class="form-control" id="weight"
                                   value="{{$article->weight ?? ''}}">
                        </div>


                        <div class="slug d-flex align-items-center">
                            <div class="form-group slug__el" id="slug__toggle">
                                <input type="text" name="slug" class="form-control" id="slug"
                                       value="{{$article->slug ?? ''}}"
                                       readonly>
                            </div>
                            <div class="form-group slug__el form-check slug__checkbox ml-3">
                                <input type="checkbox" name="slug__change" class="form-check-input" id="slug__change">
                                <label class="form-check-label" for="exampleCheck1">Задать slug</label>
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
                            <textarea name="description_short" class="form-control"
                                      id="description_short">{{$article->description_short ?? ''}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Описание</label>
                            <textarea name="description" class="form-control"
                                      id="description">{{ $article->description ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="title">Мета-Заголовок</label>
                            <input type="text" name="meta_title" class="form-control" id="meta_title"
                                   value="{{$article->meta_title ?? ''}}">
                        </div>

                        <div class="form-group">
                            <label for="title">Мета-Описание</label>
                            <input type="text" name="meta_description" class="form-control" id="meta_description"
                                   value="{{$article->meta_description ?? ''}}">
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
                        <input type="submit" class="btn btn-block btn-primary" value="Сохранить">
                        <input type="hidden" name="modified_by" value="{{Auth::id()}}">
                    </div>
                </div>
                <div class="col-md-3 p-0 create-form__right">
                    <div class="create-form__right__inner">


                        <div class="moderate">
                            <div class="form-group">
                                <label for="moderate">Модерация</label>
                                <select name="moderate" class="form-control" id="moderate">
                                    <option value="1" @if($article->moderate == 1) selected="" @endif>Пройдено
                                    </option>
                                    <option value="0" @if($article->moderate == 0) selected="" @endif>Не пройдено</option>
                                </select>
                            </div>

                            @foreach($rules as $type)

                                <div class="form-check">
                                    <input type="checkbox" name="rule[]"
                                           @if(isset($selectedRules['rule']))
                                                 @if(in_array($type->id,  $selectedRules['rule']))checked @endif
                                           @endif
                                           value="{{$type->id}}" class="form-check-input" id="rule_{{$type->id}}">
                                    <label class="form-check-label" for="rule_{{$type->id}}">{{$type->title}}</label>
                                </div>
                            @endforeach
                            <hr>

                            <div class="form-group">
                                <label for="published">Комментарий</label>
                                <textarea name="moderate_text" class="form-control"
                                          id="moderate_text">{{ $selectedRules['moderate_text'] ?? '' }}</textarea>
                            </div>
                            <input type="hidden" name="moderate_id" value="{{ $selectedRules['id'] ?? ''}}">
                        </div>




                        <div class="js_postUpMsg post-up__msg"></div>
                        <button class="js_postUp btn btn-success btn-block post-update mb-3" data-id="{{$article->id}}">
                            Поднять
                        </button>
                        <div class="p-3 create-form__item single-img">
                            <div class="create-form__title">Основная картинка<br>
                                Загрузите свои изображения<br>
                                не более 5 файлов. (jpeg, png)
                            </div>
                            <div class="form-group single-img__group">
                                <input multiple name="image[]" type="file" id="file_" value=""
                                       data-count="{{(count($article->images)) ?? 0}}" class="single-img__input">
                                <div class="create-form__error"></div>
                            </div>
                        </div>
                        <input type="hidden" name="main_image" id="main_image">
                        <div id="image-list" class="create-form__preview image-preview">
                            @if(isset($article->images))
                                @foreach($article->images->sortByDesc('main') as $image)
                                    <div class="image-preview__item @if ($image->main) image_main @endif"
                                         onclick="setAsMain(this, '{{$image->name}}')">
                                        <img src="{{$image->image_path}}" alt="">
                                        <input type="hidden" name="old_files[]" value="{{$image->image_path}}">
                                        <span class="image-preview__name"></span>
                                        <svg onclick="formsFile.removeFile(this)" data-name="" class="image-preview__del">
                                            <use xlink:href="/images/icons.svg#icon-close"></use>
                                        </svg>
                                    </div>
                                @endforeach
                            @endif
                            <div class="fake-upload">
                                <img class="fake-upload__img" src="{{ asset('images/file-upload3.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

