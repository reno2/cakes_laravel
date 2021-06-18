@extends('layouts.profile')

@section('content')

    <div class="card">

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


        </div>
    </div>

@endsection
