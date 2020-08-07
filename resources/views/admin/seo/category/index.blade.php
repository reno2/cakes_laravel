@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Список категорий @endslot
        @slot('parents') Главная @endslot
        @slot('active') Категории @endslot
    @endcomponent

    <div class="row">
        <div class="col-sm-9">
            <div class="form">
                <form id="seometa" action="{{route('seo.category.update')}}"  method='POST'>
                    {{csrf_field()}}
                    <input type="hidden" name="type" value="category">
                    <input type="hidden" name="id" value="{{$category->id ?? ''}}">
                     <div class="block ">
                         <div class="block__category">
                             <div class="form-group">
                                 <label for="title">Тег title для категории</label>
                                 <input type="text" name="title" class="form-control" id="title" value="{{$category->title ?? ''}}">
                             </div>
                             <div class="form-group">
                                 <label for="h1">Тег h1 для категории</label>
                                 <input type="text" name="h1" class="form-control" id="h1" value="{{$category->h1 ?? ''}}">
                             </div>
                             <div class="form-group">
                                 <label for="keywords">Тег meta-keywords для категории</label>
                                 <input type="text" name="keywords" class="form-control" id="keywords" value="{{$category->keywords ?? ''}}">
                             </div>
                             <div class="form-group">
                                 <label for="description">Тег meta-description для категории</label>
                                 <textarea name="description" class="form-control" id="description">
{{$category->description ?? ''}}
                                 </textarea>
                             </div>

                         </div>
                     </div>

                    <input type="submit" class="btn btn-block btn-primary" value="Изменить  категорию">
                </form>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="seo-vars">
                <ul class="seo-vars__ul">
                    <li class="seo-vars__li">#title# - Название категории</li>
                    <li class="seo-vars__li">#description# - Описание категории</li>
                </ul>
            </div>
        </div>
    </div>



@endsection



