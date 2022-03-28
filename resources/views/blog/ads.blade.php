@extends('layouts.app')
@section('title')
    {{ SeometaFacade::getData('title') }}
    {!! SeometaFacade::getData('description') !!}
@endsection

@section('content')

    @include('chunks.massages_errors')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>


    @include('chunks.block_title', ['article' => $ad])

    <div class="container">
        <div class="ad-detail">
            @include('ads.ad_detail')
        </div>
    </div>

@endsection


@section('page-script')
@stop
