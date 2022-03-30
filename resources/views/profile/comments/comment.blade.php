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



        <div class="ui-card ">
            <div class="card-body comment-page">


                    <div class="comment-page__top">

                        @if($comment)
                            <div class="p-comment">
                                <div class="p-comment__date">
                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($comment['created_at']))->diffForHumans()}}
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

