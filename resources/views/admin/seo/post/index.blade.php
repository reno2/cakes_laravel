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
                <form id="seometa" action="{{route('seo.post.update')}}"  method='POST'>
                    {{csrf_field()}}
                    <input type="hidden" name="type" value="post">
                    <input type="hidden" name="id" value="{{$post->id ?? ''}}">
                     <div class="block ">
                         <div class="block__category">
                             <div class="form-group">
                                 <label for="title">Тег title для поста</label>
                                 <input type="text" name="title" class="form-control" id="title" value="{{$post->title ?? ''}}">
                             </div>
                             <div class="form-group">
                                 <label for="h1">Тег h1 для поста</label>
                                 <input type="text" name="h1" class="form-control" id="h1" value="{{$post->h1 ?? ''}}">
                             </div>
{{--                             <div class="form-group">--}}
{{--                                 <label for="keywords">Тег meta-keywords для поста</label>--}}
{{--                                 <input type="text" name="keywords" class="form-control" id="keywords" value="{{$post->keywords ?? ''}}">--}}
{{--                             </div>--}}
                             <div class="form-group">
                                 <label for="description">Тег meta-description для поста</label>
                                 <textarea name="description" class="form-control" id="description">
{{$post->description ?? ''}}
                                 </textarea>
                             </div>

                         </div>
                     </div>

                    <input type="submit" class="btn btn-block btn-primary" value="Изменить пост">
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



