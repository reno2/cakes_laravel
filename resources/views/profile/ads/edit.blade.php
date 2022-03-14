<h3> Новое объявление</h3>
<div class="card_ ui-card">

    <div class="js_fullLoader preloader">
        <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor"
                  d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
            </path>
        </svg>
    </div>

    <div class="ui-card__body">

        @if (session('status'))
            @include('chunks.error', ['errors' => session('status')])
        @endif
        @if (session('danger'))
                @include('chunks.error', ['errors' => session('danger')])
        @endif
        @if($errors->any())

                @include('chunks.error', ['errors' => $errors->all()])
        @endif


        </div>
        <form method="post" id="post-image" action="{{ route('profile.ads.update', $ads)}}" class="js_adsCreate create-form"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label for="published" class="form-group__placeholder">Статус</label>
                <div class="form-group__inputs">
                    <select name="published" class="form-control form-group__select" id="published">
                        <option value="1" @if($ads->published == 1) selected="" @endif>Опубликовано</option>
                        <option value="0" @if($ads->published == 0) selected="" @endif>Не опубликовано</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="published" class="form-group__placeholder">Поднят объявление</label>
                <div class="form-group__inputs">
                    <div class="js_postUpMsg post-up__msg"></div>
                    <button class="btn-middle btn-grey js_postUp btn btn-success btn-block post-update mb-3" data-id="{{$ads->id}}">
                        Поднять
                    </button>
                </div>
            </div>

            <addresssearchstreet-component
                target="street"
                user-city="{{$profile->address}}"
                value="{{ old('deal_address', $ads->deal_address) }}"
                message="@error('deal_address') {{$message}} @enderror">
            ></addresssearchstreet-component>

            <div class="form-group row">
                <label for="delivery_self" class="form-group__placeholder">Возможна доставка</label>
                <div class="form-group__inputs">
                    <div class="form-check">
                        <input name="delivery_self" value="0" type="hidden">
                        <input name="delivery_self" class="form-check-input" value="1" type="checkbox" id="delivery_self" @if($ads->delivery_self == 1) checked @endif>

                        <small id="hint" class="text-muted">
                            Можете договарится с клиентом о доставке
                        </small>
                        @error('delivery_self')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            @if(false)
            <div class="form-group row">
                <label for="product_type" class="form-group__placeholder">Тип</label>
                <div class="col-md-7">
                    <select name="product_type"
                            class="form-control  @error('product_type') is-invalid @enderror" id="product_type">
                        <option value="product" @if($ads->product_type == 'product') selected="" @endif>Готовое
                            изделие
                        </option>
                        <option value="order" @if($ads->product_type == 'order') selected="" @endif>Продукт под заказ
                        </option>
                    </select>
                    @error('product_type')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            @endif

            <div class="form-group row @error('title') onError @enderror">
                <label for="title" class="form-group__placeholder">Название</label>
                <div class="form-group__inputs">
                    <input id="title" type="text"
                           class="form-group__input form-control @error('title') is-invalid @enderror" name="title"
                           value="{{old('title', $ads->title)}}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="price" class="form-group__placeholder">Стоимость Руб.</label>
                <div class="form-group__inputs">
                    <input id="price" type="text"
                           class="form-group__input js_numbersPoint js_validate form-control @error('price') is-invalid @enderror" name="price"
                           autocomplete="off"
                           value="{{old('price', $ads->price)}}">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="invalid-feedback js_error js_numbersPoint" role="alert">
                          <strong>Возможно только цифры и точка</strong>
                    </span>
                </div>
            </div>


            <div class="form-group row">
                <label for="weight" class="form-group__placeholder">Вес г.</label>
                <div class="form-group__inputs">
                    <input id="weight" type="text"
                           class="form-group__input js_maskWeight js_mask js_numbersPoint js_validate form-control @error('weight') is-invalid @enderror" name="weight"
                           value="{{old('weight', $ads->weight)}}">

                    <span class="invalid-feedback js_error js_numbersPoint" role="alert">
                          <strong>Возможно только цифры</strong>
                    </span>

                    @error('weight')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="form-group__placeholder">Описание</label>
                <div class="form-group__inputs">
                    <textarea name="description" class="form-group__textarea form-control @error('description') is-invalid @enderror"
                              id="description">{{old('description', $ads->description)}}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="tags" class="form-group__placeholder">Теги
                    <span></span>
                </label>
                <div class="form-group__inputs">
                    <select multiple="" name="tags[]" id="tags"  class="form-group__select form-control @error('tags') is-invalid @enderror">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->title}}</option>
                        @endforeach
                    </select>
                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="categories" class="form-group__placeholder">Родительская категория</label>
                <div class="form-group__inputs">
                    <select name="categories[]" class="form-group__select form-control @error('categories') is-invalid @enderror"
                            id="categories">
                        <option value="0">Выбрать категорию</option>
                        @include('profile.ads.categories', ['categories' => $categories, ])
                    </select>
                    @error('categories')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            @if(false)
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
            @endif


{{--            <multifileupload-component db-main="{{$main}}" old-files="{{$mediaFiles}}"></multifileupload-component>--}}

            <div class="form-group row">
                <label for="categories" class="form-group__placeholder">Изображения</label>
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

                    <div id="image-list" class="create-form__preview image-preview">
                        @if($mediaFiles)
                            @foreach($mediaFiles as $image)
                                <div class="image-preview__item js_newImgItem
                                     @if ($image['main']) image_main @endif"
                                     onclick="setAsMain(this, '{{$image['file_name']}}')">
                                    <img src="{{$image['src']}}" alt="">
                                    <input type="hidden" name="old_files[]" value="{{$image['file_name']}}">
                                    <span class="image-preview__name">{{$image['file_name']}}</span>
                                    <svg onclick="removeFromArray(this)"
                                         data-to-del="{{$image['id']}}"
                                         data-name=""
                                         class="image-preview__del">
                                        <use xlink:href="/images/icons.svg#icon-close"></use>
                                    </svg>
                                </div>
                            @endforeach
                        @endif
                            <div class="fake-upload">
                                <img class="fake-upload__img" src="{{ asset('images/file-upload3.svg') }}" alt="">
                            </div>
                    </div>

                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="hidden" name="main_image" id="main_image">
                    <input type="hidden" id="delete_ids" name="remove">
                    <input type="hidden" id="main" name="main" value="{{$main}}">
                </div>
            </div>
            <div class="form-group__actions form-group__single">
                <div class="offset-md-4 col-md-8">
                    <input type="submit" class="btn-main btn-middle half" value="Изменить запись">
                    <input type="hidden" name="modified_by" value="{{Auth::id()}}">
                </div>
            </div>
        </form>
    </div>
</div>

