@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')

    @if (session('status'))
        <div class="ui-card">
            <div class="ui-card__body">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="ui-card">
        <div class="ui-card__body">
            <div class="container">
                <div class="row justify-content-start ads">
                    <div class="list-group  w-100 mt-3">
                        <div class="block">
                            <div class="block-title">
                                <div class="block-title__main">
                                    Мои вопросы
                                </div>
                                <div class="block-title__bb"></div>
                            </div>
                            @forelse($userQuestions as $room)
                                <div class="i-comment">
                                    <div class="i-comment__data">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($room->last_date))->diffForHumans()}}
                                    </div>
                                    <div class="i-comment__col">
                                        <a class="i-comment__link" href="{{route('comments.comment', $room->room_id)}}">
                                            @if ($room->media_id)
                                                <img class="i-comment__img"
                                                     src='{{asset("storage/media/{$room->media_id}/{$room->file_name}")}}'>
                                            @else
                                                <img class="i-comment__img"
                                                     src="{{ url('storage/images/defaults/cake.svg') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="i-comment__content">
                                        <div class="i-comment__title">
                                            <a href="{{route('comments.comment', $room->room_id)}}">
                                                {{$room->title}} {{$room->room_id}}
                                            </a>
                                        </div>
                                    </div>
                                    @if(isset($fromAuthorNotReadAnswer[$room->article_id]))
                                        <div class="i-comment__new">
                                            <span class="info-badge blue">
                                                Новых {{$fromAuthorNotReadAnswer[$room->article_id]->count}}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="nothing">
                                    <div class="nothing__img"></div>
                                    <div class="nothing__text">Нет вопросов</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui-card mt-4">
        <div class="ui-card__body">
            <div class="container">
                <div class="block-title">
                    <div class="block-title__main">
                        Вопросы мне
                    </div>
                    <div class="block-title__bb"></div>
                </div>
            </div>
        </div>
    </div>

    @forelse($toUserQuestions as $room)
        <div class="ui-card mt-4">
            <div class="ui-card__body">
                <div class="container">
                    <div class="i-comment">
                        <div class="i-comment__data">
                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($room->last_date))->diffForHumans()}}
                        </div>

                        <div class="i-comment__col">
                            <a class="i-comment__link" href="{{route('comments.comment', $room->room_id)}}">
                                @if ($room->media_id)
                                    <img class="i-comment__img"
                                         src="{{asset('storage/media/'.$room->media_id.'/'.$room->file_name)}}">
                                @else
                                    <img class="i-comment__img"
                                         src="{{ url('storage/images/defaults/cake.svg') }}">
                                @endif
                            </a>
                        </div>

                        <div class="i-comment__content">
                            <div class="i-comment__title">
                                <a href="{{route('comments.comment', $room->room_id)}}">{{$room->title}}</a>
                            </div>
                            <div class="i-comment__desc">
                                {{$room->count}} вопроса от {{$room->name}}
                            </div>
                        </div>
                        @if($room->not_read)
                            <div class="i-comment__new">
                                <span class="info-badge blue">
                                    Новых {{$room->not_read}}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div>Нет вопросов</div>
    @endforelse




    <ul class="pagination pull-right">
        {{--        {{$comments>links()}}--}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')

@stop

