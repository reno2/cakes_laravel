<div class="form-group">
    <label for="published">Статус</label>
    <select name="published" class="form-control" id="published">
        @if(isset($tag->id))
            <option value="0" @if($tag->published == 0) selected="" @endif>Не опубликовано</option>
            <option value="1" @if($tag->published == 1) selected="" @endif>Опубликовано</option>
        @else
            <option value="0">Не опубликовано</option>
            <option value="1">Опубликовано</option>
        @endif


    </select>
</div>

<div class="form-group form-check">
    <input  type="checkbox" value="1" name="important" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Важный</label>
</div>


<div class="form-group">
    <label for="title">Название</label>
    <input type="text" name="name" class="form-control" id="name" value="{{(old('name')) ?? ($tag->name) ?? ''}}">
</div>



<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" name="slug" class="form-control" id="slug" value="{{(old('slug')) ?? $tag->slug ?? ''}}" readonly="">
</div>


<div class="form-group">
    <select multiple name="tags[]" id="tags">
        @foreach($articles as $article)
            <option value="{{$article->id}}">{{$article->title}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="">Краткое описание</label>
    <textarea name="description_short" class="form-control" id="description_short">{{(old('description_short')) ?? $tag->description_short ?? ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Описание</label>
    <textarea name="description" class="form-control" id="description">{!! $tag->description ?? ''!!}</textarea>
</div>
<hr><br>
<div class="form-group">
    <h4>Мета-Заголовки</h4>
</div>
<div class="form-group">
    <label for="title">Мета-Заголовок</label>
    <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{(old('meta_title')) ?? $tag->meta_title ?? ''}}">
</div>

<div class="form-group">
    <label for="title">Мета-Описание</label>
    <input type="text" name="meta_description" class="form-control" id="meta_description" value="{{(old('meta_description')) ?? $tag->meta_description ?? ''}}">
</div>
<div class="form-group">
    <label for="title">Мета-Keywords</label>
    <input type="text" name="meta_keywords" class="form-control" id="meta_description" value="{{(old('meta_keywords')) ?? $tag->meta_keywords ?? ''}}">
</div>




<hr>
<input type="submit" class="btn btn-block btn-primary" value="Добавить категорию">
