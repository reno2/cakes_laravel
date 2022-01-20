<div class="form-group">
    <label for="published">Статус</label>
    <select name="published" class="form-control" id="published">
        @if(isset($category->id))
            <option value="0" @if($category->published == 0) selected="" @endif>Не опубликовано</option>
            <option value="1" @if($category->published == 1) selected="" @endif>Опубликовано</option>
        @else
            <option value="0">Не опубликовано</option>
            <option value="1">Опубликовано</option>
        @endif


    </select>
</div>

<div class="form-group">
    <label for="title">Сортировка</label>
    <input type="text" name="sort" class="form-control" id="name" value="{{$category->sort ?? 100}}">
</div>

<div class="slug d-flex align-items-center">

    <div class="form-group slug__el" id="slug__toggle">
        <input type="text" name="slug" class="form-control" id="slug" value="{{$category->slug ?? ''}}" readonly>
    </div>
    <div class="form-group slug__el form-check slug__checkbox ml-3">
        <input type="checkbox" name="slug__change" class="form-check-input" id="slug__change">
        <label class="form-check-label" for="exampleCheck1">Задать slug</label>
    </div>

</div>

<div class="form-group">
    <label for="title">Название</label>
    <input type="text" name="title" class="form-control" id="name" value="{{$category->title ?? ''}}">
</div>

<div class="form-group">
    <label for="description">Описание</label>
    <textarea name="description" class="form-control" id="description">{{$category->description ?? ''}}</textarea>
</div>

<div class="form-group">
    <label for="categories">Родительская категория</label>
    <select name="parent_id" class="form-control" id="categories">
        <option value="0">-- без родителей</option>

        @include('admin.categories.partials.categories', ['categories' => $categories])



    </select>
</div>
<hr>
<h3>
    Настройки SEO
    <small class="text-muted"> </small></h3>
    <div class="form-group">
        <label for="h1">h1</label>
        <input type="text" name="h1" class="form-control" id="h1" value="{{$category->h1 ?? ''}}">
    </div>
    <div class="form-group">
        <label for="meta_keywords">meta_keywords</label>
        <input type="text" name="meta_keywords" class="form-control" id="meta_keywords" value="{{$category->meta_keywords ?? ''}}">
    </div>

    <div class="form-group">
        <label for="description">meta_description</label>
        <textarea name="meta_description" class="form-control" id="description">{{$category->meta_description ?? ''}}</textarea>
    </div>


<hr>
<input type="submit" class="btn btn-block btn-primary" value="@if(isset($category->id)) Изменить @else Добавить @endif категорию">

