@extends('layouts.profile')

@section('content')


    <div class="comment">
        <div class="back-block">
            <a class="btn btn-middle blue" href="{{route('comments.index')}}">
                <svg class="rotateLeft i-svg i-svg__tw">
                    <use xlink:href="/images/icons.svg#icon-arrow"></use>
                </svg>
                Назад к вопросам
            </a>
        </div>

        @if($ads['deleted_at'])
            <div class="error-block">
                <ul class="error-block__ul">
                  <li class="error-block__li">Убъявление удалено</li>
                </ul>
            </div>
        @endif

        <div class="ui-card ">
            <div class="card-body comment-page">

                    <div class="comment-page__top">
                        @if($comment)
                            <div class="p-comment">
                                <div class="p-comment__date">
                                    последнее: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($last_updated_date->updated_at))->diffForHumans()}}
                                </div>
                                <div class="">
                                    <h5 class="p-comment__title mb-1">
                                        {{$ads['title']}}
                                    </h5>
                                    <p class="p-comment__desc mb-1">Вопрос от {{$profile['name']}} ({{$comment['from_user_id']}})</p>
                                </div>
                            </div>
                        @else
                            <div>Никаких объявлений не отложенно</div>
                        @endif
                    </div>





                <addcomment
                        ads="{{$ads['id']}}"
                        comment-users="{{$users}}"
                        user="{{$user}}"
                        is-deleted="{{($ads['deleted_at']) ? 1 : 0 }}"
                        subs="{{$sub}}"
                        comment-id="{{$comment['id'] ?? ''}}"
                        route-create="{{route('comments.answer', $comment['id'] ?? '')}}"
                        route-update="{{route('comments.update', $comment['id'] ?? '')}}"
                        token="{{ csrf_token() }}"
                        room="{{$room}}"
                >
                </addcomment>


            </div>
        </div>
    </div>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')

@stop

