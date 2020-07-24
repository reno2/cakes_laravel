@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if($res)
                <div class="mt-5 col info info_good">
                    По запросу <i>"{{$search}}"</i> Найдено <strong>{{count($res)}}</strong> записи
                </div>
        </div>
        <div class="row">
            @forelse($res as $article)
                @include('chunks.listItem', ['article' => $article])

            @empty
                <h2 class="text-center">Пусто</h2>
            @endforelse


        </div>
        @else
            <div class="mt-5 col info info_good">
                По запросу нет записей
            </div>
        @endif


    </div>



@endsection
