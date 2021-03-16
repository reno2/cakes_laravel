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
                <div class="row justify-content-start">
                    <a class="btn btn-success" href="{{route("profile.ads.create")}}">Добавить объявление</a>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-start ads">
                    <div class="list-group  w-100 mt-3">

                        @if($comment)
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Объявление - <strong>{{$ads->title}}</strong> ({{$comment->article_id}})</h5>
                                    <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}</small>
                                </div>
                                <p class="mb-1">Вопрос от {{$comment->name}} ({{$comment->from_user_id}})</p>
                                <p>Отправитель: {{$sender}}</p>
                                <p>Получатель: {{$recipient}}</p>
                                <i class="fas fa-comment-alt"> </i> <small> перейти к вопросам ({{$comment->id}})</small>
                            </a>
                        @else
                            <div>Никаких объявлений не отложенно</div>
                        @endif
                    </div>
                </div>




            </div>
            <addcomment
                ads="{{$ads->id}}"
                sender="{{$sender}}"
                recipient="{{$recipient}}"
                current-user-id="{{$userId}}"
                subs="{{$sub}}"
                comment-id="{{$comment->id}}"
                route="{{route('comments.update', $comment->id)}}"
                token="{{ csrf_token() }}">
            </addcomment>
        </div>
    </div>
    <ul class="pagination pull-right">
        {{--        {{$comments>links()}}--}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')

@stop

