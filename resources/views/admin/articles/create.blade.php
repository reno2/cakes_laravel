@extends('admin.layouts.app_admin')



@section('content')




        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Материалы'];
        @endphp
        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Создание материала @endslot
{{--            @slot('parent') Главная @endslot--}}
            @slot('active') Материал @endslot
        @endcomponent
        <div class="row">
            <div class="col-md-9" id="aform">
            <form сlass="form-horizontal" action="{{route('admin.article.store')}}" method="post">
                {{csrf_field()}}
                {{-- Form include--}}

                @include('admin.articles.partials.form')
                <input type="hidden" name="created_by" value="{{Auth::id()}}">

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

