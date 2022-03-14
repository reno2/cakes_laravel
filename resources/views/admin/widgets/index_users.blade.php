<div class="list-table list-table__{{$entity}}">
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
                    <div class="list-table__val">{{$value->active}}</div>
                    <div class="list-table__val">
                        @if($value->email_verified_at)
                            <span class="info-badge green">on</span>
                        @else
                            <span class="info-badge red">off</span>
                        @endif
                    </div>
                    <div class="list-table__val">{{$value->created_at}}</div>
                    <div class="list-table__val">{{$value->name}}</div>
                    <div class="list-table__val">{{$value->email}}</div>
                    <div class="list-table__val">{{$value->articles->count()}}</div>
                    <div class="list-table__val">{{$value->is_admin}}</div>
                    <div class="list-table__val list-table_figure">
                        <img class="list-table__img" src="{{$value->image}}">
                    </div>



                    <div class="list-table__val">

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

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>