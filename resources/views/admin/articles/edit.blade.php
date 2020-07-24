@extends('admin.layouts.app_admin')


@section('content')

        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Категории'];
        @endphp
        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Редактирование материала @endslot
{{--            @slot('parents') Главная @endslot--}}
            @slot('active') редактирование @endslot
        @endcomponent
        <div class="row">
            <div class="col-md-9" id="aform">
            <form сlass="form-horizontal" id="aform" action="{{route('admin.article.update', $article)}}" method="post">
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
                {{-- Form include--}}

                @include('admin.articles.partials.form')
                <input type="hidden" name="modified_by" value="{{Auth::id()}}">

            </form>
            </div>
        </div>



@endsection

@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var $select2 = $('#tags').select2({

            })
            $('#tags').select2().val({!! json_encode($article->tags()->allRelatedIds()) !!}).trigger('change');
            //$select2.data('select2').$container.find('input').addClass("form-control")

        });
    </script>
    <style>
        .select2{
            display:block;
            width: 100% !important;
        }
        li.select2-search{
            width: 100%;
        }
    </style>

@endsection