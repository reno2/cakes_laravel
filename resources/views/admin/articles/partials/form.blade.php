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

<input  type="checkbox" @if(isset($article->on_front) && $article->on_front == true) checked @endif  name="on_front" class="form-check-input" id="exampleCheck1">
<label class="form-check-label" for="exampleCheck1">Показывать на главной</label>
</div>


<div class="form-group">
<label for="title">Заголовок</label>
<input type="text" name="title" class="form-control" id="name" value="
@if(isset($article->title))
{{$article->title}}
@elseif(old('title'))
{{old('title')}}
@else
@endif
">
</div>


<div class="form-group">
<label for="title">Сортировка</label>
<input type="text" name="sort" class="form-control" id="sort" value="{{$article->sort ?? ''}}">
</div>



<div class="slug d-flex align-items-center">

    <div class="form-group slug__el" id="slug__toggle">

        <input type="text" name="slug" class="form-control" id="slug" value="{{$article->slug ?? ''}}" readonly>
    </div>
    <div class="form-group slug__el form-check slug__checkbox ml-3">
        <input type="checkbox" name="slug__change" class="form-check-input" id="slug__change">
        <label class="form-check-label" for="exampleCheck1">Задать slug</label>
    </div>

</div>


<div class="form-group">
<select multiple="" name="tags[]" id="tags">
    @foreach($tags as $tag)
        <option value="{{$tag->id}}">{{$tag->name}}</option>
    @endforeach


</select>
</div>

<div class="form-group">
<label for="">Краткое описание</label>
<textarea name="description_short" class="form-control" id="description_short">{{$article->description_short ?? ''}}</textarea>
</div>

<div class="form-group">
<label for="">Описание</label>
<textarea name="description" class="form-control" id="description">{{ $article->description ?? '' }}</textarea>
</div>

<div class="form-group">
<label for="title">Мета-Заголовок</label>
<input type="text" name="meta_title" class="form-control" id="meta_title" value="{{$article->meta_title ?? ''}}">
</div>

<div class="form-group">
<label for="title">Мета-Описание</label>
<input type="text" name="meta_description" class="form-control" id="meta_description" value="{{$article->meta_description ?? ''}}">
</div>

<div class="form-group">
<label for="categories">Родительская категория</label>
<select name="categories[]" class="form-control" id="categories" multiple>
    <option value="0">-- без родителей</option>

    @include('admin.articles.partials.categories', ['categories' => $categories])



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

    <input  type="checkbox" value="" name="reload" class="form-check-input" id="reload">
    <label class="form-check-label" for="reload">Не возвращатся к списку</label>
</div>
<hr>
<input type="submit" class="btn btn-block btn-primary" value="Сохранить">
