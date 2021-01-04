<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>--}}
{{--    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">--}}
{{--    <title>{!!  MetaTag::setTitle('title') !!}</title>--}}



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="admin">

    <div class="d-flex justify-content-start admin-apage">
        <div class="apage">
            <div class="sidebar">
                @include('admin.components.sidebar2')
            </div>
        </div>
        <div class="apage marea flex-fill">
{{--            @include('admin.components.top')--}}

            <div class="marea-middle marea__item">
                @include('chunks.messeges')
                <div class="col-md-9">
                @include('chunks.errors')
                </div>
                <div class="container-fluid pt-5 pl-5 pr-5">
                 @yield('content')
                </div>
            </div>
            @include('admin.components.footer')
        </div>
    </div>
</div>

@yield('page-script')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/forms.js')}}"></script>
<!-- Scripts -->
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<link href="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css') }}" rel="stylesheet">
<script src="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js') }}"></script>
<script src="{{asset('js/backend.js')}}"></script>
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
