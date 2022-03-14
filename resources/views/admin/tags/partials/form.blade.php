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
    <label for="name" class="form-group__placeholder  @error('name') onError @enderror">Название</label>
    <div class="form-group__inputs">
        <input type="text" name="name" class="form-group__input" id="name" value="{{(old('name')) ?? ($tag->name) ?? ''}}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="slug" class="form-group__placeholder  @error('slug') onError @enderror">Slug</label>
    <div class="form-group__inputs">
        <input readonly type="text" name="slug" class="form-group__input" id="name" value="{{(old('slug')) ?? ($tag->slug) ?? ''}}">
        @error('slug')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


@if(isset($tag->id))
    <div class="form-group">
        <select multiple name="tags[]" id="tags">
            @foreach($articles as $article)
                <option value="{{$article->id}}">{{$article->title}}</option>
            @endforeach
        </select>
    </div>
@endif


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

<div class="form-group file-loader_one js_file-loader file-loader @error('iamge') onError @enderror">
    <label for="description" class=" form-group__placeholder">Картинка</label>
    <div class="col-md-7 form-group__inputs">

        <input name="image[]" type="file" multiple value=""
               data-rules='{"limit": "2", "size": "100000", "type": "jpeg"}'
               data-validate=""
               class="js_fileInput js_file-loader__input">

        <div id="image-list" class="create-form__preview image-preview">

        </div>
        <div class="file-loader__preview js_thumbs__previews">

        </div>

        <button type="button" class="js_file-loader__proxy file-loader__proxy fake-upload btn-middle btn-grey wide">Загрузить</button>

        <div class="create-form__error js_file-loader__error file-loader__error"></div>
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

