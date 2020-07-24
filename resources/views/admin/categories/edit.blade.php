@extends('admin.layouts.app_admin')


@section('content')

        @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.category.index'), 'title' => 'Категории'];
        @endphp

    @component('admin.components.breadcrumb', ['parents'=>$parents])
            @slot('title') Редактирование категории @endslot
{{--            @slot('parent') Главная @endslot--}}
            @slot('active') Редактирование @endslot
        @endcomponent
        <div class="row">

                <div class="col-sm-9">
                    <form сlass="form-horizontal" id="aform" action="{{route('admin.category.update', $category)}}" method="post">
                        <input type="hidden" name="_method" value="put">
                        {{csrf_field()}}
                        {{-- Form include--}}
                        @include('admin.categories.partials.form')
                        <input type="hidden" name="image" value="{{$category->image ?? ''}}" id="category-img">
                    </form>
                </div>
                <div class="col-sm-3">
                    <div class="cart">
                        <div class="card-body">
                            <form id="aform"  onsubmit="return upload()" action="{{route('img_add')}}"  enctype="multipart/form-data">

                                <div class="form-group">
                                    <input name="image" type="file" id="file_">
                                </div>
                                <button class="btn-block btn btn-success" type="submit">загрузить</button>
                            </form>
                            <div>
                                <img src="{{$category->image ?? ''}}" @if(!isset($category->image))style="display: none;"@endif id="post_img" class="img-fluid"  alt="">
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
        axios.post('{{route("img_add")}}',
            formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }

            }).then(function (response) {
            if(response.data){
                let img = document.getElementById('post_img');
                img.style.display='block';
                img.setAttribute('src', response.data.image);
                document.getElementById('category-img').value = response.data.image;
            }
            console.log(response.data.image);
        })

        return false;
    }


</script>