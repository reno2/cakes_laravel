@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection
@section('content')

    <div class="container">
        {!!  SeometaFacade::getData('h1')  !!}
    </div>

    @include('chunks.massages_errors')
    <div class="container">



        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container">
          Для удаления данных, напишите на почту remove@2cake.ru
        </div>
    </div>

@endsection

