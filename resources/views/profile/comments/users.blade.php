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
                        <h4></h4>
                        @forelse($data as $d)

                            <a href="{{route('comments.comment',
                                        ['article_id' => $d->article_id, 'user_id' => $d->from_user_id])}}">
                                <div class="i-comment">
                                    <div class="i-comment__data">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}
                                    </div>
                                    <div class="i-comment__col">
                                        <a href="{{route('comments.article', $d->article_id)}}">
                                            @if ($d->image)
                                                <img class="i-comment__img" src="{{Storage::url($d->image)}}">
                                            @else
                                                <img class="i-comment__img" src="{{url('storage/images/avatar/default.svg') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="i-comment__content">
                                        <div class="i-comment__title">
                                            <a href="{{route('comments.comment',
                                                ['article_id' => $d->article_id, 'user_id' => $d->from_user_id])}}">{{$d->title}}</a>
                                        </div>
                                        <div class="i-comment__desc">
                                            Вопросы от {{$d->name}} пользователей
                                        </div>
                                    </div>
                                </div>
                        @empty
                            <div>Никаких объявлений не отложенно</div>
                        @endforelse


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

