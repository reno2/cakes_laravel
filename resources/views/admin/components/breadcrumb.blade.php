<h2 class="mt-3">
	{{$title}}
</h2>

<div class="breadcrumb admin">

        <ol class="breadcrumb__ul">
            @if(is_array($parents))
                @foreach($parents as $parent)
                <li class="breadcrumb__item">
                    <a class="breadcrumb__link" href="{{$parent['link']}}">{{$parent['title']}}</a>
                    <span class="breadcrumb_slash">/</span>
                </li>

                @endforeach
            @else
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="{{route('admin.index')}}">{{$parents}}</a>
                <span class="breadcrumb_slash">/</span>
            </li>
            @endif
            <li class="breadcrumb__item active" aria-current="page">{{$active}}</li>
        </ol>

</div>
