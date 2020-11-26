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
    <div class="row create-form">
        <div class="col-md-9 create-form__left">
            <div class="create-form__item p-3" id="aform">
                <form сlass="form-horizontal" action="{{route('admin.article.store')}}" method="post">
                    {{csrf_field()}}
                    {{-- Form include--}}
                    @include('admin.articles.partials.form')
                    <input type="hidden" name="created_by" value="{{Auth::id()}}">

                </form>
            </div>
        </div>
        <div class="col-md-3 p-0 create-form__right">
            <div class="p-3 create-form__item single-img">
                <div class="create-form__title">Основная картинка</div>
                <form action="{{route('img_add')}}" class="create-form__form single-img__form" id="post-image"
                      enctype="multipart/form-data">

                    <div class="form-group single-img__group">
                        <input multiple name="image" type="file" id="file_" class="single-img__input">
                        <div class="create-form__error"></div>
                    </div>
                    <button class="btn-block btn btn-success single-img__btn" type="submit">загрузить</button>
                </form>
            </div>
            <div id="image-list" class="create-form__preview image-preview">
                <img style="display: none;" id="post_img" class="img-fluid single-img__image" alt="">
            </div>
        </div>

    </div>



@endsection


@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            var $select2 = $('#tags').select2({})
            //     placeholder: "Search for an Item",
            //     minimumInputLength: 2,
            //     ajax: {
            //         url: '/autocomplete',
            //         dataType: 'json',
            //         type: "GET",
            //         data: function (term) {
            //             return {
            //                 term: term
            //             };
            //         },
            //         processResults: function (data, page) {
            //             var response = JSON.parse(data);
            //             return {
            //                 results: response
            //             };
            //         }
            //     }
            // })
            //$select2.data('select2').$container.find('input').addClass("form-control")

        });
    </script>
    <style>
        .select2 {
            display: block;
            width: 100% !important;
        }

        li.select2-search {
            width: 100%;
        }
    </style>

@endsection

