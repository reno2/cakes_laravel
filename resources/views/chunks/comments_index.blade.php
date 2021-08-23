<div class="ui-card mt-4">
    <div class="ui-card__body">
        <div class="container">
            <div class="i-comment">
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
                    <div class="i-comment__title">
                        <a href="{{route('comments.comment', $room->room_id)}}">{{$room->title}}</a>
                    </div>
                    <div class="i-comment__desc">
                        {{$room->count}} вопроса от {{$room->name}}
                    </div>
                </div>
                @isset($room->not_read)
                    <div class="i-comment__new">
                        <span class="info-badge blue">
                            Новых {{$room->not_read}}
                        </span>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>