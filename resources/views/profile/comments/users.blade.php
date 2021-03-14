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
                            <a href="{{route('comments.comment', ['article_id' => $d->article_id, 'user_id' => $d->from_user_id])}}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    #{{$d->id}}
                                    <h5 class="mb-1">{{$d->title}}</h5>
                                    <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->last_date))->diffForHumans()}}</small>
                                </div>
{{--                                <p class="mb-1">от пользователя <strong>{{$d->name}} - {{$d->from_user_id}}</strong></p>--}}
                                <p class="mb-1">Вопросы от пользователя {{$d->name}} ({{$d->from_user_id}})</p>
                                <i class="fas fa-comment-alt"> </i> <small> перейти к вопросам</small>
                            </a>
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

