@extends('layouts.app')

@section('content')
{{--    @include('layouts.hero')--}}
{{--    @include('layouts.front-info')--}}

    <div class="container">
        <div class="row">
            @php
               // $p = \App\SBlog\Core\BlogApp::get_Instance()->getProperty('admin_email');
            @endphp

            {{--        {{dd($articles)}}--}}
            @foreach($articles as $article)
                @include('chunks.listItem', ['article' => $article])
            @endforeach
        </div>
    </div>

@endsection
