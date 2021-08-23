@extends('layouts.profile')

@section('content')


    @include('chunks.all_massages')

    <div class="back-block">
        <a class="btn btn-middle blue" href="{{route('comments.index')}}">
            <svg class="rotateLeft i-svg i-svg__tw">
                <use xlink:href="/images/icons.svg#icon-arrow"></use>
            </svg>
            Назад к вопросам
        </a>
    </div>



        <div class="_card ui-card">
            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-start ads">
                    <div class="list-group  w-100 mt-3">

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
                </div>




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
    <ul class="pagination pull-right">
        {{--        {{$comments>links()}}--}}
    </ul>
@endsection
{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')

@stop

