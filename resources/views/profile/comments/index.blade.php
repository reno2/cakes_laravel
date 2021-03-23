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

                        <div class="block">
                            <div class="block-title">
                                <div class="block-title__main">
                                    Мои вопросы
                                </div>
                                <div class="block-title__bb"></div>
                            </div>
                            @forelse($userQuestions as $d)
                                <div class="i-comment">
                                    <div class="i-comment__data">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}
                                    </div>
                                    <div class="i-comment__col">
                                        <a href="{{route('comments.article', $d->article_id)}}">
                                            @if ($d->media_id)
                                                <img class="i-comment__img"
                                                     src="{{asset('storage/media/'.$d->media_id.'/'.$d->file_name)}}">
                                            @else
                                                <img class="i-comment__img"
                                                     src="{{ url('storage/images/icons/cake.svg') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="i-comment__content">
                                        <div class="i-comment__title">
                                            <a href="{{route('comments.article', $d->article_id)}}">
                                                {{$d->title}}
                                            </a>
                                        </div>
                                    </div>
                                    @if(isset($fromAuthorNotReadAnswer[$d->article_id]))
                                        <div class="i-comment__new">
                                                <span class="info-badge blue">
                                                    Новых {{$fromAuthorNotReadAnswer[$d->article_id]->count}}
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

                        <div class="block mt-4">
                            <div class="block-title">
                                <div class="block-title__main">
                                    Вопросы мне
                                </div>
                                <div class="block-title__bb"></div>
                            </div>
                            @forelse($toUserQuestions as $d)
                                <div class="i-comment">
                                    <div class="i-comment__data">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}
                                    </div>

                                    <div class="i-comment__col">
                                        <a href="{{route('comments.article', $d->article_id)}}">
                                            @if ($d->media_id)
                                                <img class="i-comment__img"
                                                     src="{{asset('storage/media/'.$d->media_id.'/'.$d->file_name)}}">
                                            @else
                                                <img class="i-comment__img"
                                                     src="{{ url('storage/images/icons/cake.svg') }}">
                                            @endif
                                        </a>
                                    </div>

                                    <div class="i-comment__content">
                                        <div class="i-comment__title">
                                            <a href="{{route('comments.article', $d->article_id)}}">{{$d->title}}</a>
                                        </div>
                                        <div class="i-comment__desc">
                                            Вопросы от {{$d->count}} пользователей
                                        </div>
                                    </div>
                                    @if(isset($toAuthorQuestionsNotAnswer[$d->article_id]))
                                        <div class="i-comment__new">
                                                <span class="info-badge blue">
                                                    Новых {{$toAuthorQuestionsNotAnswer[$d->article_id]->count}}
                                                </span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div>Нет вопросов</div>
                            @endforelse
                        </div>
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

