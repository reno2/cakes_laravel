@extends('layouts.profile')

@section('content')


    <div class="ui-tabs js_tabs">
        <div class="ui-tabs__head">
            <button class="blue btn-middle ui-tabs__head-item js_tabLink active">
                Вопросы мне @if($notReadQuestions) <span class="comment_isNew"></span>@endif
            </button>
            <button class="blue btn-middle ui-tabs__head-item js_tabLink">
                Мои вопросы @if($notReadAnswers)<span class="comment_isNew"></span>@endif
            </button>
        </div>

        <div class="ui-tabs__content">
            <div class="ui-tabs__content-item js_tabContent active @if(empty($toUserQuestions)) not_empty @endif">
                @forelse($toUserQuestions as $room)
                    @include('chunks.comments_to')
                @empty
                    <div class="nothing">
                        <div class="nothing__img"></div>
                        <div class="nothing__text">Нет вопросов</div>
                    </div>
                @endforelse
            </div>
            <div class="ui-tabs__content-item js_tabContent @if(empty($userQuestions)) not_empty @endif">
                @forelse($userQuestions as $room)
                    @include('chunks.comments_from')
                @empty
                    <div>Нет вопросов</div>
                @endforelse
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

