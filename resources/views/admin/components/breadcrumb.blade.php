<h2 class="mt-3">
	{{$title}}
</h2>

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if(is_array($parents))
                @foreach($parents as $parent)
                <li class="breadcrumb-item">
                    <a href="{{$parent['link']}}">{{$parent['title']}}</a>
                </li>
                @endforeach
            @else
            <li class="breadcrumb-item">
                    <a href="{{route('admin.index')}}">{{$parents}}</a>
            </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{$active}}</li>
        </ol>
    </nav>
</div>
