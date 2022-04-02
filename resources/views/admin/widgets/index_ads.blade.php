<div class="list-table list-table__ads">
    <div class="list-table__inner">

        <div class="list-table__head">
            @foreach($heads as $head)
                <div class="list-table__tab">{{$head}}</div>
            @endforeach
        </div>
        <div class="list-table__body">
            @foreach($values as $value)

                <div class="list-table__row">
                    <div class="list-table__val">{{$value->id}}</div>
                    <div class="list-table__val">
                        @if($value->published)
                            <span class="info-badge green">on</span>
                        @else
                            <span class="info-badge red">off</span>
                        @endif
                    </div>
                    <div class="list-table__val">{{$value->created_at}}</div>
                    <div class="list-table__val">{{$value->sort}}</div>
                    <div class="list-table__val">{{$value->moderate}}</div>
                    <div class="list-table__val">{{$value->on_front}}</div>
                    <div class="list-table__val">{{$value->userEmail}}</div>
                    <div class="list-table__val">{{$value->title}}</div>
                    <div class="list-table__val">{{$value->slug}}</div>



                    <div class="list-table__val">({{$value->tags->count()}}) {{$value->tagsNames}}</div>
                    <div class="list-table__val">{{$value->categoryName}}</div>

                    <div class="list-table__val list-table_figure">
                        <img class="list-table__img" src="{{$value->image}}">
                    </div>
                    <div class="list-table__val">
                        @if($value->trashed())
                            <form class="widget__actions"  action="{{route("admin.{$entity}.restore", $value)}}" method="post">
                                {{csrf_field()}}
                                <button type="submit" class="widget__action btn-square btn-icon">
                                    <svg class="list-table__svg">
                                        <use xlink:href="{{asset('images/back-icons.svg#fa-restore')}}"></use>
                                    </svg>
                                </button>
                            </form>
                            <form class="widget__actions" onsubmit="if(confirm('Удалить навсегда?')){return true} else {return false}" action="{{route("admin.{$entity}.force_delete", $value)}}" method="post">
                                {{csrf_field()}}
                                <button type="submit" class="widget__action btn-square btn-icon">
                                    <svg class="list-table__svg">
                                        <use xlink:href="{{asset('/images/icons.svg#icon-close')}}"></use>
                                    </svg>
                                </button>
                            </form>
                        @else
                        <form class="widget__actions" onsubmit="if(confirm('Удалить?')){return true} else {return false}" action="{{route("admin.{$entity}.destroy", $value)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{csrf_field()}}
                            <button type="submit" class="widget__action btn-square btn-icon">
                                <svg class="list-table__svg">
                                    <use xlink:href="{{asset('images/back-icons.svg#icon-trash')}}"></use>
                                </svg>
                            </button>
                            <a class="widget__action btn-square btn-icon" href="{{route("admin.{$entity}.edit", $value)}}">
                                <svg class="list-table__svg">
                                    <use xlink:href="{{asset('images/back-icons.svg#icon-edit')}}"></use>
                                </svg>
                            </a>
                            <a class="widget__action btn-square btn-icon" href="{{route("admin.{$entity}.show", $value)}}">
                                <svg class="list-table__svg">
                                    <use xlink:href="{{asset('images/back-icons.svg#icon-search')}}"></use>
                                </svg>
                            </a>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>