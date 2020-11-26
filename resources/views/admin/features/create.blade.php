@extends('admin.layouts.app_admin')
@section('content')




    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.article.index'), 'title' => 'Свойства'];
    @endphp
    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Создание свойства @endslot
        @slot('active') Свойства @endslot
    @endcomponent
    <div class="row">
        <div class="col-md-6" id="aform">
            <form сlass="form-horizontal" action="{{route('admin.features.store')}}" method="post">

                {{-- Form include--}}
                @include('admin.features.partials.form')
                <input type="hidden" name="created_by" value="{{Auth::id()}}">

            </form>
        </div>
    </div>



@endsection


@section('page-script')

    <script>
        $(document).ready(function() {

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
