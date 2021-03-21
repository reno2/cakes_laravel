@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')


    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-start ads">
                    <div class="list-group  w-100 mt-3">


                            @if($userQuestions->isNotEmpty())
                                <h4 class="my-3">Мои вопросы</h4>
                                @forelse($userQuestions as $d)
                                    <a href="{{route('comments.article', $d->article_id)}}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            #{{$d->id}}
                                            <h5 class="mb-1">Объявление - {{$d->title}} ({{$d->article_id}})</h5>
                                            <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}</small>
                                        </div>
                                        <p class="mb-1">Вопросы от пользователя {{$d->name}} с id {{$d->from_user_id}}</p>
                                        <i class="fas fa-comment-alt"> </i> <small> перейти к вопросам</small>
                                    </a>
                                @empty
                                    <div>Никаких объявлений не отложенно</div>
                                @endforelse
                            @endif

                            @if($toUserQuestions->isNotEmpty())
                                <div class="block-title">
                                    <div class="block-title__main">
                                        Вопросы мне
                                    </div>
                                    <div class="block-title__bb"></div>
                                </div>
                                @forelse($toUserQuestions as $d)
                                    <a href="{{route('comments.article', $d->article_id)}}" class="i-comment">
                                        <div class="i-comment__data">
                                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}
                                        </div>
                                        <div class="i-comment__col">
                                            <img class="i-comment__img" src="{{asset('storage/media/'.$d->media_id.'/'.$d->file_name)}}">
                                        </div>
                                        <div class="i-comment__content">
                                            <div class="i-comment__title">{{$d->title}}</div>
                                            <div class="i-comment__desc">
                                                Вопросы от {{$d->count}} пользователей
                                            </div>
                                        </div>


{{--                                        <div class="d-flex w-100 justify-content-between">--}}
{{--                                            <div>--}}
{{--                                                #{{$d->id}}--}}
{{--                                                <h5 class="mb-1">Объявление - {{$d->title}} ({{$d->article_id}})</h5>--}}
{{--                                                <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}</small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p class="mb-1">Вопросы от {{$d->count}} пользователей</p>--}}
{{--                                        <i class="fas fa-comment-alt"> </i> <small> перейти к вопросам</small>--}}
                                    </a>
                                @empty
                                    <div>Никаких объявлений не отложенно</div>
                                @endforelse
                            @endif




                    </div>
                </div>
            </div>


        </div>
    </div>
    <ul class="pagination pull-right">
{{--        {{$comments>links()}}--}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')

@stop

