<div class="form-group">
    <label for="published">Статус</label>
    <select name="published" class="form-control" id="published">
        @if(isset($article->id))
            <option value="0" @if($article->published == 0) selected="" @endif>Не опубликовано</option>
            <option value="1" @if($article->published == 1) selected="" @endif>Опубликовано</option>
        @else
            <option value="0">Не опубликовано</option>
            <option value="1">Опубликовано</option>
        @endif


    </select>
</div>

<div class="form-group form-check">
    <input  type="checkbox" value="1" name="on_front" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Показывать на главной</label>
</div>


<div class="form-group">
    <label for="title">Заголовок</label>
    <input type="text" name="title" class="form-control" id="name" value="{{$article->title or ''}}">
</div>



<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" name="slug" class="form-control" id="slug" value="{{$article->slug or ''}}" readonly="">
</div>


<div class="form-group">
    <select multiple="" name="e9" id="e9">
            <option value="AK">Alaska</option>
            <option value="HI">Hawaii</option>
    </select>
</div>

<div class="form-group">
    <label for="">Краткое описание</label>
    <textarea name="description_short" class="form-control" id="description_short">{{$article->description_short or ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Описание</label>
    <textarea name="description" class="form-control" id="description">{!! $article->description or ''!!}</textarea>
</div>

<div class="form-group">
    <label for="title">Мета-Заголовок</label>
    <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{$article->meta_title or ''}}">
</div>

<div class="form-group">
    <label for="title">Мета-Описание</label>
    <input type="text" name="meta_description" class="form-control" id="meta_description" value="{{$article->meta_description or ''}}">
</div>

<div class="form-group">
    <label for="categories">Родительская категория</label>
    <select name="categories[]" class="form-control" id="categories" multiple>
        <option value="0">-- без родителей</option>

        @include('admin.articles.partials.categories', ['categories' => $categories]);



    </select>
</div>



<hr>
<input type="submit" class="btn btn-block btn-primary" value="Добавить категорию">
