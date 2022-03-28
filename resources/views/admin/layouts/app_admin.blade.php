<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


{!! SeometaFacade::getStaticTag('title') !!}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="admin dashboard">

    <div class="d-flex justify-content-start admin-apage dashboard-container">
        <div class="admin-page__sidebar dashboard__sidebar">

            @include('admin.components.sidebar2')

        </div>
        <div class="apage marea flex-fill dashboard__content">

            <div class="dashboard__main">

                @include('chunks.massages_errors')

                @include('chunks.errors')

                <div class="dashboard__body">
                 @yield('content')
                </div>
            </div>
            @include('admin.components.footer')
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('page-script')
<script src="{{ asset('js/main.js')}}"></script>
<!-- Scripts -->
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<link href="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css') }}" rel="stylesheet">
<script src="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js') }}"></script>
<script src="{{asset('js/backend.js')}}"></script>
<script src="{{asset('js/fileLoader.js')}}"></script>
<script>


    {{--setTimeout(function(){--}}
    {{--    var konten = document.getElementById("description");--}}
    {{--    CKEDITOR.replace(konten,{--}}
    {{--        language:'en-gb',--}}
    {{--        extraPlugins: 'coder,justify',--}}
    {{--        filebrowserUploadUrl: '{{route('ckeditor.upload', ['_token' => csrf_token() ])}}',--}}
    {{--        filebrowserUploadMethod: 'form'--}}
    {{--    });--}}
    {{--    CKEDITOR.config.allowedContent = true;--}}
    {{--    CKEDITOR.config.entities = true;--}}
    {{--    //CKEDITOR.config.htmlEncodeOutput = false;--}}


    {{--}, 400)--}}
</script>


<script>hljs.initHighlightingOnLoad();</script>

<style>img.img-fluid{width: 100%;}</style>
</body>
</html>
