<div class="card">
    <div class="card-header">
        Новое объявление
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
        @endif
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
               {{$errors->first()}}
                </div>
            @endif

        <form method="post" id="post-image" action="{{ route('profile.ads.store')}}" class="js_adsCreate create-form"
              enctype="multipart/form-data" class="js_adsCreate">
            @csrf
            <div class="form-group row">
                <label for="published" class="col-md-4 col-form-label text-md-right">Статус</label>
                <div class="col-md-7">
                    <select name="published" class="form-control" id="published">
                        <option value="0">Опубликовано</option>
                        <option value="1">Не опубликовано</option>
                    </select>
                </div>
            </div>

            <multipleselect-component
                target="street"
                user-city="{{$profile->address}}"
                value="{{ old('deal_address') }}"
                message="@error('deal_address') {{$message}} @enderror">
                ></multipleselect-component>

            <div class="form-group row">
                <label for="product_type" class="col-md-4 col-form-label text-md-right">Тип</label>
                <div class="col-md-7">
                    <select name="product_type"
                            class="form-control  @error('product_type') is-invalid @enderror" id="product_type">
                        <option value="product">Готовое изделие</option>
                        <option value="order">Продукт под заказ</option>
                    </select>
                    @error('product_type')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">Название</label>
                <div class="col-md-7">
                    <input id="title" type="text"
                           class="form-control @error('title') is-invalid @enderror" name="title"
                           value="{{old('title')}}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-md-4 col-form-label text-md-right">Стоимость Руб.</label>
                <div class="col-md-2">
                    <input id="price" type="text"
                           class="form-control @error('price') is-invalid @enderror" name="price"
                           value="{{old('price')}}">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="weight" class="col-md-4 col-form-label text-md-right">Вес г.</label>
                <div class="col-md-2">
                    <input id="weight" type="text"
                           class="form-control @error('weight') is-invalid @enderror" name="weight"
                           value="{{old('weight')}}">
                    @error('weight')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">Описание</label>
                <div class="col-md-7">
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              id="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="tags" class="col-md-4 col-form-label text-md-right">Теги
                    <span></span>
                </label>
                <div class="col-md-7">
                    <select multiple="" name="tags[]" id="tags">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="categories" class="col-md-4 col-form-label text-md-right">Родительская категория</label>
                <div class="col-md-7">
                    <select name="categories[]" class="form-control @error('categories') is-invalid @enderror"
                            id="categories">
                        <option value="0">Выбрать категорию</option>
                        @include('admin.articles.partials.categories', ['categories' => $categories, ])
                    </select>
                    @error('categories')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="categories" class="col-md-4 col-form-label text-md-right">Фильтры продукта
                    <br> объезятельно заполнить хоть один
                </label>
                <div class="col-md-7">

                    @if(isset($filter))
                        @widget('articleCreate', ['tpl'=>'Widgets::frontFiltersGroup', 'filter' => $filter])
                    @else
                        @widget('articleCreate', ['tpl'=>'Widgets::frontFiltersGroup', 'filter' => null])
                    @endif
                </div>
            </div>




            <div class="form-group row">
                <label for="categories" class="col-md-4 col-form-label text-md-right">Изображения</label>
                <div class="col-md-7 p-0 create-form__right">
                    <div class="js_postUpMsg post-up__msg"></div>
                    <div class="p-3 create-form__item single-img">
                        <div class="create-form__title">Основная картинка<br>
                            Загрузите свои изображения<br>
                            не более 5 файлов. (jpeg, png)
                        </div>

                        <div class="form-group single-img__group">
                            <input multiple name="image[]" type="file" id="file_" value=""
                                   data-count="0" class="js_fileInput single-img__input">
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

            <div class="form-group row">
                <div class="offset-md-4 col-md-8">
                    <input type="submit" class="btn btn-block btn-primary" value="Создать запись">
                    <input type="hidden" name="modified_by" value="{{Auth::id()}}">
                </div>
            </div>
        </form>
    </div>
</div>
