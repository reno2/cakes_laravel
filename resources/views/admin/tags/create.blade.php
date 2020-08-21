@extends('admin.layouts.app_admin')



@section('content')




        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.tags.index'), 'title' => 'теги'];
        @endphp
        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Создание тега @endslot
{{--            @slot('parent') Главная @endslot--}}
            @slot('active') Тег @endslot
        @endcomponent
        <div class="row">
            <div class="col-sm-9">

            <form сlass="form-horizontal" action="{{route('admin.tags.store')}}" method="post">
                {{csrf_field()}}
                {{-- Form include--}}

                @include('admin.tags.partials.form')
                <input type="hidden" name="created_by" value="{{Auth::id()}}">

            </form>
            </div>
        </div>



@endsection


@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function() {
            var $select2 = $('#tags').select2({
                minimumInputLength: 2,
                tags: false,
                createSearchChoice: function(term, data) {
                    if ($(data).filter(function() {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                },
                ajax: {
                    url: '/autocomplete',
                    // dataType: 'json',
                    // type: "GET",
                    // quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },


                    processResults: function (data) {
                        console.log(data)

                        return {
                            results: data
                        };
                    }
                }
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

