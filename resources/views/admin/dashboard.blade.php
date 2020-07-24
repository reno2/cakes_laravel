@extends('admin.layouts.app_admin')


@section('content')

        <div class="row dash">
            <div class="col-sm-3">
                <div class="jumbotron dash-item dcat">
                    <p>
                        <span class="label label-primary">
                            Категорий {{$count_categories}}
                        </span>
                    </p>
                    <div class="dash-item__icon">
                        <img src="{{asset('/images/category128.png')}}" alt="">

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="jumbotron dash-item dpost">
                    <p>
                        <span class="label label-primary">
                            Материалов {{$count_articles}}
                        </span>
                    </p>
                    <div class="dash-item__icon">
                        <img src="{{asset('/images/title128.png')}}" alt="">

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="jumbotron dash-item dusers">
                    <p>
                        <span class="label label-primary">
                            Пользователей {{$count_users}}
                        </span>
                    </p>
                    <div class="dash-item__icon">
                        <img src="{{asset('/images/followers.png')}}" alt="">

                    </div>
                    <div class="dash-item__icon">


                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="jumbotron dash-item dtoday">
                    <p>
                        <span class="label label-primary">
                            Потом что-нибудь выведу
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <a href="{{route('admin.category.create')}}" class="btn btn-block btn-default">Создать категорию</a>
                @foreach($categories as $category)
                <a href="{{route('admin.category.edit', $category)}}" class="list-group-item">
                    <h4 class="list-group-item-heading">{{$category->title}}</h4>
                    <p class="list-group-item-text">{{$category->articles->count()}}</p>
                </a>
                @endforeach
            </div>
            <div class="col-sm-6">
                <a href="{{route('admin.article.create')}}" class="btn btn-block btn-default">Создать материал</a>
                @foreach($articles as $article)
                <a href="{{route('admin.article.edit', $article)}}" class="list-group-item">
                    <h4 class="list-group-item-heading">{{$article->title}}</h4>
                    <p class="list-group-item-text">{{$article->categories->pluck('title')->implode(',', '')}}</p>
                </a>
                @endforeach
            </div>
        </div>


@endsection