@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Шаблоны для главной @endslot
        @slot('parents') Главная @endslot
        @slot('active') Категории @endslot
    @endcomponent

    <div class="row">
        <div class="col-sm-9">
            <div class="form">
                <form id="seometa" action="{{route('seo.front.update')}}" method='POST'>
                    {{csrf_field()}}
                    <input type="hidden" name="type" value="front">
                    <input type="hidden" name="id" value="{{$front->id ?? ''}}">
                    <div class="block ">
                        <div class="block__category">
                            <div class="form-group">
                                <label for="title">Тег title для категории</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{$front->title ?? config('seo.title')}}">
                            </div>
                            <div class="form-group">
                                <label for="h1">Тег h1 для категории</label>
                                <input type="text" name="h1" class="form-control" id="h1" value="{{$front->h1 ?? config('seo.h1')}}">
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="keywords">Тег meta-keywords для категории</label>--}}
{{--                                <input type="text" name="keywords" class="form-control" id="keywords" value="{{$front->keywords ?? ''}}">--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label for="description">Тег meta-description для категории</label>
                                <textarea name="description" class="form-control" id="description">{{$front->description ?? config('seo.description')}}</textarea>
                            </div>

                        </div>
                    </div>

                    <input type="submit" class="btn btn-block btn-primary" value="Изменить сео для главной">
                </form>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="back-sidebar">


                <div class="back-sidebar__block">
                    <div class="back-sidebar__title">
                        Значение по умолчанию
                    </div>
                    <div class="back-sidebar__content">
                        <ul class="back-sidebar__ul">
                            @foreach(config('seo') as $key => $seo)
                                <li class="back-sidebar__li">{{$key}} - {{$seo}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection



