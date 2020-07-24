@extends('admin.layouts.app_admin')


@section('content')

        @php $parents = [];
             $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
             $parents[] = ['link' => route('admin.category.index'), 'title' => 'Категории'];
        @endphp


        @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Создание категории @endslot
            @slot('active') Создать @endslot
        @endcomponent
        <div class="row">
            <div class="col-sm-9">
            <form сlass="form-horizontal"  id="aform" action="{{route('admin.category.store')}}" method="post">
                {{csrf_field()}}
                {{-- Form include--}}

                @include('admin.categories.partials.form')
                <input type="hidden" name="image" value="" id="category-img">

            </form>
            </div>
            <div class="col-sm-3">
                <div class="cart">
                    <div class="card-body">
                    <form id="aform" onsubmit="return upload()" action=""  enctype="multipart/form-data">

                        <div class="form-group">
                        <input name="image" type="file" id="file_">
                        </div>
                        <button class="btn-block btn btn-success" type="submit">загрузить</button>
                    </form>
                        <div>
                            <img style="display: none;" id="post_img" class="img-fluid" src="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection



    <script>
        function upload(){
           let formData = new FormData();
           let file = document.getElementById('file_');
           formData.append("image", file.files[0]);
           //console.log(formData.get('image'));

            //console.log(formData.get(name));
            {{--axios.post('{{route("img_add")}}',--}}
            {{--   formData, {--}}
            {{--      headers: {--}}
            {{--          'Content-Type': 'multipart/form-data'--}}
            {{--      }--}}

            {{--    }).then(function (response) {--}}
            {{--        if(response.data){--}}
            {{--            let img = document.getElementById('post_img');--}}
            {{--            img.style.display='block';--}}
            {{--            img.setAttribute('src', response.data.image);--}}
            {{--            document.getElementById('category-img').value = response.data.image;--}}
            {{--        }--}}
            {{--        console.log(response.data.image);--}}
            {{--    })--}}

            return false;
        }


    </script>
