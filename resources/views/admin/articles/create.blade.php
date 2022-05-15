@section('content')

    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Объявления'];
    @endphp
    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Редактирование объявление @endslot
        @slot('active') редактирование @endslot
    @endcomponent

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form action="{{route('admin.article.store')}}"
                          method="post"
                          enctype="multipart/form-data"
                          class="dashboard-form create-form">


                        {{csrf_field()}}


                        <div class="form-group">
                            <label for="published" class="form-group__placeholder">Статус</label>
                            <div class="form-group__inputs">
                                <select name="published" class="form-group__select form-control @error('published') is-invalid @enderror" id="published">
                                    <option value="0">Не опубликовано</option>
                                    <option value="1">Опубликовано</option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group form-check">
                            <label class="form-group__placeholder" for="moderate">На главной</label>
                            <div class="form-group__inputs">
                                <input name="on_front" value="0" type="hidden">
                                <input type="checkbox" value="1" checked="checked" name="on_front" class="form-group__checkbox" id="on_front">
                                @error('on_front')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <addresssearchstreet-component
                                target="street"
                                user-city="Санкт-Петербург"
                                value="{{ old('deal_address') }}"
                                message="@error('deal_address') {{$message}} @enderror">
                            >
                        </addresssearchstreet-component>


                        <div class="form-group form-check">
                            <label class="form-group__placeholder" for="moderate">Модерация</label>
                            <div class="form-group__inputs">

                                <input type="checkbox"  name="moderate" class="form-group__checkbox" id="moderate">
                                @error('moderate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group form-check">
                            <label class="form-group__placeholder" for="slug_change">Изменить slug</label>
                            <div class="form-group__inputs">

                                <input type="checkbox"  data-slug-input="js_slug__input" name="slug_change" class="js_slug__change form-group__checkbox" id="slug_change">
                                @error('slug_change')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="slug" class="form-group__placeholder  @error('slug') onError @enderror">Slug</label>
                            <div class="form-group__inputs">
                                <input readonly="readonly"  type="text" name="slug" class="form-group__input js_slug__input" id="name" value="{{ old('slug')}}">
                                @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

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


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('title') onError @enderror">Название</label>
                            <div class="form-group__inputs">
                                <input type="text" name="title" class="form-group__input" id="name" value="{{old('title') ?? ''}}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name" class="form-group__placeholder  @error('sort') onError @enderror">Сортировка</label>
                            <div class="form-group__inputs">
                                <input type="text" name="sort" class="form-group__input" id="name" value="{{old('sort')  ?? ''}}">
                                @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dial_price" class="form-group__placeholder"></label>
                            <div class="form-group__inputs">
                                <div class="form-check">
                                    <input class="form-check-input form-group__checkbox js_deal__price"  type="checkbox" id="dial_price">
                                    <label id="hint" for="dial_price" class="form-group__small text-muted">
                                        Цена по договорённости
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group  js_form-group row  @error('price') onError @enderror">
                            <label for="price" class="col-md-4 col-form-label text-md-right form-group__placeholder">Стоимость Руб.</label>
                            <div class="col-md-2 form-group__inputs">
                                <input id="price" type="text"
                                       class="js_pay__price form-group__input js_numbersPoint js_validate form-control @error('price') is-invalid @enderror" name="price"
                                       autocomplete="off"
                                       value="{{old('price')}}">
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
                                    <strong>Возможно только цифры</strong>
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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tags" class="form-group__placeholder">Автор</label>
                            <div class="form-group__inputs">
                                <select multiple="" name="user_id" class="authors">
                                    <option value="{{Auth::id()}}" selected="selected">{{Auth::user()->email}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tags" class="form-group__placeholder">Теги
                                <span></span>
                            </label>
                            <div class="form-group__inputs">
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
                                    @include('profile.ads.categories', ['categories' => $categories])
                                </select>
                                @error('categories')
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
                        {{-- region Image --}}
                        <input name="image[]" type="file" multiple value=""
                               class="js_fileInput js_file-loader__input js_tag-image file-loader__hidden">
                        <input type="hidden" name="main_image" id="main_image">
                        {{-- endregion Image --}}

                        <input type="hidden" name="created_by" value="{{Auth::id()}}">



                    </form>
                </div>

                <div class="info-cards__block">
                    <div class="info-block">
                        <div class="info-block__name">Изображение</div>
                        <div class="info-block__data">

                            <div class="file-loader_half js_file-loader file-loader @error('image') onError @enderror"
                            >
                                <div class="file-loader__thumbs js_thumbs" data-hash="">

                                    <div class="file-loader__preview js_images-preview images-preview">


                                    </div>

                                    <button
                                            data-validate=""
                                            data-rules='{"limit": "5", "size": "100000", "type": "jpeg"}'
                                            data-proxy="js_tag-image"
                                            type="button"
                                            class="js_file-loader__proxy file-loader__proxy btn-middle btn-grey wide">Загрузить
                                    </button>

                                    <div class="create-form__error js_file-loader__error file-loader__error"></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
