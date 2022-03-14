@extends('admin.layouts.app_admin')


@section('content')
    <div class="info-cards">
        <div class="info-cards__row">
            @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.tags.index'), 'title' => 'Теги'];
            @endphp
            @component('admin.components.breadcrumb', ['parents'=>$parents])
                @slot('title') Редактирование тега @endslot
                {{--            @slot('parents') Главная @endslot--}}
                @slot('active') редактирование @endslot
            @endcomponent
        </div>
    </div>

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form сlass="dashboard-form create-form" action="{{route('admin.tags.update', $tag)}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="put">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="published" class="form-group__placeholder">Статус</label>
                            <div class="form-group__inputs">
                                <select name="published" class="form-group__select form-control @error('published') is-invalid @enderror" id="published">
                                    <option value="0" @if($tag->published == 0) selected="" @endif>Не опубликовано</option>
                                    <option value="1" @if($tag->published == 1) selected="" @endif>Опубликовано</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-check">
                            <label class="form-group__placeholder" for="exampleCheck1">Важный</label>
                            <div class="form-group__inputs">
                                <input name="important" value="0" type="hidden">
                                <input type="checkbox" value="1" name="important" class="form-group__checkbox" id="exampleCheck1">
                                @error('important')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('title') onError @enderror">Название</label>
                            <div class="form-group__inputs">
                                <input type="text" name="title" class="form-group__input" id="title" value="{{ (old('title')) ?? ($tag->title) ?? '' }}">
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
                                <input type="text" name="sort" class="form-group__input" id="name" value="{{(old('sort')) ?? ($tag->sort) ?? ''}}">
                                @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slug" class="form-group__placeholder  @error('slug') onError @enderror">Slug</label>
                            <div class="form-group__inputs">
                                <input readonly type="text" name="slug" class="form-group__input" id="slug" value="{{(old('slug')) ?? ($tag->slug) ?? ''}}">
                                @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row @error('description_short') onError @enderror">
                            <label for="description" class="col-md-4 col-form-label text-md-right form-group__placeholder">Краткое описание</label>
                            <div class="col-md-7 form-group__inputs">
                                <textarea name="description" class="form-group__textarea form-control @error('description_short') is-invalid @enderror"
                                          id="description">{{old('description_short')}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('description') onError @enderror">
                            <label for="description" class="form-group__placeholder">Описание</label>
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

                        <hr>
                        <div class="form-group">
                            <h4 class="form-group__placeholder ">Мета-Заголовки</h4>
                        </div>


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('meta_title') onError @enderror">Мета-Keywords</label>
                            <div class="form-group__inputs">
                                <input type="text" name="meta_title" class="form-group__input" id="meta_title" value="{{(old('meta_title')) ?? ($tag->meta_title) ?? ''}}">
                                @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('meta_keywords') onError @enderror">Мета-Заголовок</label>
                            <div class="form-group__inputs">
                                <input type="text" name="meta_title" class="form-group__input" id="meta_title" value="{{(old('meta_keywords')) ?? ($tag->meta_keywords) ?? ''}}">
                                @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('meta_description') onError @enderror">
                            <label for="description" class="col-md-4 col-form-label text-md-right form-group__placeholder">Мета-Описание</label>
                            <div class="col-md-7 form-group__inputs">
                                <textarea name="description" class="form-group__textarea form-control @error('meta_description') is-invalid @enderror"
                                          id="description">{{old('meta_description')}}</textarea>
                                @error('description')
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

                        <input type="hidden" name="tag_img_del" class="js_tag__del">
                        <input type="hidden" name="created_by" value="{{Auth::id()}}">

                    </form>
                </div>

                <div class="info-cards__block">

                    <div class="info-block">
                        <div class="info-block__name">Изображение</div>
                        <div class="info-block__data">

                            <div class="file-loader_one js_file-loader file-loader @error('image') onError @enderror"
                            >
                                <div class="file-loader__wrap js_thumbs" data-hash="">
                                    <div class="js_images-preview images-preview">
                                        @if(isset($tag->image))
                                            <div class="js_images-preview__item images-preview__item">
                                                <img class="images-preview__img" src="{{$tag->image}}" alt="">
                                                <div class="images-preview__bottom">
                                                    <span class="images-preview__name">{{File::name($tag->image)}}.{{File::extension($tag->image)}}</span>
                                                    <svg onclick="fileLoader.removeFromArray(this)"
                                                         data-name="${file.name}"
                                                         data-del-input="js_tag__del"
                                                         data-file-id="{{$tag->imageId}}"
                                                         class="images-preview__del js_file-loader__del js_old__file">
                                                        <use xlink:href="/images/icons.svg#icon-close"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                        @endif
                                    </div>

                                    <button
                                            data-validate=""
                                            data-rules='{"limit": "1", "size": "100000", "type": "jpeg"}'
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


