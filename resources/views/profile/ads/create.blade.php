<h3> Новое объявление</h3>
<div class="card_ ui-card">
    <div class="js_fullLoader preloader">
        <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor"
                  d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
            </path>
        </svg>
    </div>


        <form method="post" id="post-image" action="{{ route('profile.ads.store')}}" class="js_adsCreate create-form"
              enctype="multipart/form-data" class="js_adsCreate">
            @csrf
            <div class="form-group row">
                <label for="published" class="col-md-4 col-form-label text-md-right form-group__placeholder">Статус</label>
                <div class="col-md-7 form-group__inputs">
                    <select name="published" class="form-control form-group__select" id="published">
                        <option value="1">Опубликовано</option>
                        <option value="0">Не опубликовано</option>
                    </select>
                </div>
            </div>

            <addresssearchstreet-component
                    target="street"
                    user-city="{{$profile->address}}"
                    value="{{ old('deal_address') }}"
                    message="@error('deal_address') {{$message}} @enderror"
                >
            </addresssearchstreet-component>




            <div class="form-group row">
                <label for="delivery_self" class="form-group__placeholder">Возможна доставка</label>
                <div class="form-group__inputs">
                    <div class="form-check">
                        <input name="delivery_self" value="0" type="hidden">
                        <input name="delivery_self" class="form-check-input form-group__checkbox" value="1" type="checkbox" id="delivery_self">
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
                <div class="col-md-7 form-group__inputs">
                    <select name="product_type"
                            class="form-control  form-group__select @error('product_type') is-invalid @enderror" id="product_type">
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
            @endif

            <div class="form-group row @error('title') onError @enderror">
                <label for="title" class="form-group__placeholder">Название</label>
                <div class="form-group__inputs">
                    <input id="title" type="text"
                           class="form-control form-group__input @error('title') is-invalid @enderror" name="title"
                           value="{{old('title')}}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row  @error('price') onError @enderror">
                <label for="price" class="col-md-4 col-form-label text-md-right form-group__placeholder">Стоимость Руб.</label>
                <div class="col-md-2 form-group__inputs">
                    <input id="price" type="text"
                           class="form-group__input js_numbersPoint js_validate form-control @error('price') is-invalid @enderror" name="price"
                           autocomplete="off"
                           value="{{old('price')}}">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="invalid-feedback js_error js_numbersPoint" role="alert">
                       Возможно только цифры и точка
                    </span>
                </div>
            </div>
            <div class="form-group row @error('weight') onError @enderror">
                <label for="weight" class="col-md-4 col-form-label text-md-right form-group__placeholder">Вес г.</label>
                <div class="col-md-2 form-group__inputs">
                    <input id="weight" type="text"
                           class="form-group__input js_maskWeight js_mask js_numbersPoint js_validate form-control @error('weight') is-invalid @enderror" name="weight"
                           value="{{old('weight')}}">
                    @error('weight')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="invalid-feedback js_error js_numbersPoint" role="alert">
                        Возможно только цифры
                    </span>
                </div>
            </div>
            <div class="form-group row @error('description') onError @enderror">
                <label for="description" class="col-md-4 col-form-label text-md-right form-group__placeholder">Описание</label>
                <div class="col-md-7 form-group__inputs">
                    <textarea name="description" class="form-group__textarea form-control @error('description') is-invalid @enderror"
                              id="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <small id="hint" class="form-group__hint">
                       Не указывайте в описании телефон и e-mail - для это есть отдельные поля.
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label for="tags" class="col-md-4 col-form-label text-md-right form-group__placeholder">Теги
                    <span></span>
                </label>
                <div class="col-md-7 form-group__inputs">
                    <select class="form-group__select" multiple="" name="tags[]" id="tags">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row @error('categories') onError @enderror">
                <label for="categories" class="form-group__placeholder">Родительская категория</label>
                <div class="form-group__inputs">
                    <select name="categories[]" class="form-group__select form-control @error('categories') is-invalid @enderror"
                            id="categories">
                        <option value="0">Выбрать категорию</option>
                        @include('profile.ads.categories', ['categories' => $categories, ])
                    </select>
                    @error('categories')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
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



            <div class="form-group row">
                <label for="categories" class="form-group__placeholder">Изображения</label>
                <div class="create-form__right form-group__inputs">
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

            <div class="form-group__actions form-group__single">
                <div class="offset-md-4 col-md-8">
                    <input type="submit" class="btn-main btn-middle half" value="Создать запись">
                    <input type="hidden" name="modified_by" value="{{Auth::id()}}">
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                </div>
            </div>
        </form>
    </div>

