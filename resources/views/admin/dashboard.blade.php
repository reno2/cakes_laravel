@extends('admin.layouts.app_admin')


@section('content')

    <div class="info-cards">

        <div class="info-cards__row">
            <div class="info-cards__title">Количество за сегодня</div>
            <div class="info-cards__cards info-cards__today">

                <div class="info-cards__block info-card_third">
                    <div class="info-block">
                        <div class="info-block__name">Новых пользовтелей</div>
                        <div class="info-block__data">
                            {{$today_users_count}}
                        </div>
                    </div>
                </div>
                <div class="info-cards__block info-card_third">
                    <div class="info-block">
                        <div class="info-block__name">Новых объявлений</div>
                        <div class="info-block__data">
                            {{$today_articles_count}}
                        </div>
                    </div>
                </div>
                <div class="info-cards__block info-card_third">
                    <div class="info-block">
                        <div class="info-block__name">Новых комментариев</div>
                        <div class="info-block__data">
                            {{$today_comments_count}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="info-cards__row">
            <div class="info-cards__title">Данные за сегодня</div>

            <div class="info-cards__cards">

                <div class="info-cards__block info-cards_half">
                    <div class="info-block">
                        <div class="info-block__name">Пользователи</div>
                        <div class="info-block__data">
                            @include('admin.widgets.users', ['data' => $today_users])
                        </div>
                    </div>
                </div>

                <div class="info-cards__block info-cards_half">
                    <div class="info-block">
                        <div class="info-block__name">Объявления</div>
                        <div class="info-block__data info-cards__list">
                            @include('admin.widgets.ads', ['data' => $today_articles])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(false)

        <div class="row dash">
            <div class="col-sm-3">
                <div class="jumbotron dash-item dcat">
                    <p>
                        <span class="label label-primary">
                            Категорий {{$count_categories ?? 0}}
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
                            Материалов {{$count_articles ?? 0}}
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
                @if(isset($articles) && isset($categories))
                    @forelse($categories as $category)
                        <a href="{{route('admin.category.edit', $category)}}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{$category->title}}</h4>
                            <p class="list-group-item-text">{{$category->articles->count()}}</p>
                        </a>
                    @empty
                    @endforelse
                @endif
            </div>
            <div class="col-sm-6">
                <a href="{{route('admin.article.create')}}" class="btn btn-block btn-default">Создать материал</a>
                @if(isset($articles))
                    @forelse($articles as $article)
                        <a href="{{route('admin.article.edit', $article)}}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{$article->title}}</h4>
                            <p class="list-group-item-text">{{$article->categories->pluck('title')->implode(',', '')}}</p>
                        </a>
                    @empty
                    @endforelse
                @endif
            </div>
        </div>
    @endif

@endsection
