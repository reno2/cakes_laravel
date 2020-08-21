@extends('admin.layouts.app_admin')


@section('content')

        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.tags.index'), 'title' => 'Теги'];
        @endphp
        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Редактирование тега @endslot
{{--            @slot('parents') Главная @endslot--}}
            @slot('active') редактирование @endslot
        @endcomponent
        <div class="row">
            <div class="col-md-6">

            <form сlass="form-horizontal" id="aform" action="{{route('admin.tags.update', $tag)}}" method="post">
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}

                @include('admin.tags.partials.form')



            </form>
        </div> </div>



@endsection

@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // var $select2 = $('#tags').select2({
            //     minimumInputLength: 2,
            //     tags: false,
            //     createSearchChoice: function(term, data) {
            //         if ($(data).filter(function() {
            //             return this.text.localeCompare(term) === 0;
            //         }).length === 0) {
            //             return {
            //                 id: term,
            //                 text: term
            //             };
            //         }
            //     },
            //     ajax: {
            //         url: '/autocomplete',
            //         // dataType: 'json',
            //         // type: "GET",
            //         // quietMillis: 50,
            //         data: function (term) {
            //             return {
            //                 term: term
            //             };
            //         },
            //
            //
            //         processResults: function (data) {
            //             console.log(data)
            //
            //             return {
            //                 results: data
            //             };
            //         }
            //     }
            // })

            $('#tags').select2({
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
            }).val({!! json_encode($tag->articles()->allRelatedIds()) !!}).trigger('change');
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
