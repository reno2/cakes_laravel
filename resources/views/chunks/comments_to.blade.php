<div class="ui-card ui-card_no-radius">
    <div class="ui-card__body">
        <div class="container">
            <div class="i-comment i-comment__to">
                <div class="i-comment__data">
                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($room->last_date))->diffForHumans()}}
                </div>
                <div class="i-comment__col">

                    <a class="i-comment__link" href="{{route('comments.comment', $room->room_id)}}">
                        @if ($room->media_id)
                            <img class="i-comment__img"
                                 src="{{asset('storage/media/'.$room->media_id.'/'.$room->file_name)}}">
                        @else
                            <img class="i-comment__img"
                                 src="{{ url('storage/images/defaults/cake.svg') }}">
                        @endif
                    </a>
                </div>

                <div class="i-comment__content">
                    <div class="i-comment__from">
                        Вопроса от <span class="i-comment__user">{{$room->name}}</span>
                    </div>
                    <div class="i-comment__title">
                        <a href="{{route('comments.comment', $room->room_id)}}">{{$room->title}}</a>
                    </div>

                </div>
                @if($room->not_read > 0)
                    <div class="i-comment__new">
                        <span class="info-badge blue">
                            Новых {{$room->not_read}}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>