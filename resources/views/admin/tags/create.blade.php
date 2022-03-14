@extends('admin.layouts.app_admin')



@section('content')



    <div class="info-cards">
        <div class="info-cards__row">
            @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.tags.index'), 'title' => 'теги'];
            @endphp
            @component('admin.components.breadcrumb', ['parents'=>$parents])
                @slot('title') Создание тега @endslot
                @slot('active') Тег @endslot
            @endcomponent
        </div>
    </div>

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form action="{{route('admin.tags.store')}}" method="post" enctype="multipart/form-data" class="dashboard-form create-form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="published" class="form-group__placeholder">Статус</label>
                            <div class="form-group__inputs">
                                <select name="published" class="form-group__select form-control @error('published') is-invalid @enderror" id="published">
                                    @if(isset($tag->id))
                                        <option value="0" @if($tag->published == 0) selected="" @endif>Не опубликовано</option>
                                        <option value="1" @if($tag->published == 1) selected="" @endif>Опубликовано</option>
                                    @else
                                        <option value="0">Не опубликовано</option>
                                        <option value="1">Опубликовано</option>
                                    @endif


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
                                <input type="text" name="title" class="form-group__input" id="title" value="{{old('title') ?? ''}}">
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
                            <label for="slug" class="form-group__placeholder  @error('slug') onError @enderror">Slug
                                <br><small id="hint" class="text-muted">
                                    Формируется автоматически
                                </small>
                            </label>
                            <div class="form-group__inputs">
                                <input readonly type="text" name="slug" class="form-group__input" id="name" value="{{(old('slug')) ?? ($tag->slug) ?? ''}}">
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
                            <label for="meta_title" class="form-group__placeholder  @error('meta_title') onError @enderror">Мета-Keywords</label>
                            <div class="form-group__inputs">
                                <input type="text" name="meta_title" class="form-group__input" id="meta_title" value="{{old('meta_title')}}">
                                @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="meta_keywords" class="form-group__placeholder  @error('meta_keywords') onError @enderror">Мета-Заголовок</label>
                            <div class="form-group__inputs">
                                <input type="text" name="meta_keywords" class="form-group__input" id="meta_keywords" value="{{old('meta_keywords')}}">
                                @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('meta_description') onError @enderror">
                            <label for="meta_description" class="form-group__placeholder">Мета-Описание</label>
                            <div class="form-group__inputs">
                                <textarea name="meta_description" class="form-group__textarea form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description">{{old('meta_description')}}</textarea>
                                @error('meta_description')
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
                <div class="info-cards__block">

                    <div class="info-block">
                        <div class="info-block__name">Изображение</div>
                        <div class="info-block__data">

                            <div class="file-loader_one js_file-loader file-loader @error('image') onError @enderror"
                            >
                                <div class="file-loader__wrap js_thumbs" data-hash="">
                                    <div class="file-loader__preview js_images-preview images-preview">


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


@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {
            var $select2 = $('#tags').select2({
                minimumInputLength: 2,
                tags: false,
                createSearchChoice: function (term, data) {
                    if ($(data).filter(function () {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                },
                ajax: {
                    url: '/autocomplete',
                    // dataType: 'json',
                    // type: "GET",
                    // quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },


                    processResults: function (data) {
                        console.log(data);

                        return {
                            results: data
                        };
                    }
                }
            });
            //$select2.data('select2').$container.find('input').addClass("form-control")

        });
    </script>
    <style>
        .select2 {
            display: block;
            width: 100% !important;
        }
        li.select2-search {
            width: 100%;
        }
    </style>

@endsection

