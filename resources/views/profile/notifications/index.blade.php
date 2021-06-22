@extends('layouts.profile')

@section('content')

    @forelse($notifications as $notification)
        <div class="notification alert alert-success" role="alert">
            <div class="notification__name">{{($notification["data"]["event_name"]) ?? 'Общее уведомление'}}</div>
            [{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->toFormattedDateString()}}] -
            @if(isset($notification["data"]["title"]) && isset($notification["data"]["url"]))
                <a href="{{$notification["data"]["url"]}}">{{ $notification["data"]["title"] }}</a>
            @elseif(isset($notification["data"]["title"]))
                {{ $notification["data"]["title"] }}
            @else
            @endif
            @isset($notification["data"]["message"])
                <div class="notification__mess">
                    {{$notification["data"]["message"]}}
                </div>
            @endif
{{--            <a href="/profile/comments/{{ $notification->data['all']['article_id']}}/{{ $notification->data['all']['from_user_id'] }}">{{ $notification->data['advert'] }}</a>  был задан вопрос.--}}
            <a href="#" class="btn-middle blue float-right mark-as-read js_makeAsRead" data-id="{{ $notification->id }}" data-user="{{Auth::id()}}">
                Прочитать
            </a>
        </div>
        @if($loop->last)
            <a class="btn-middle blue notification__read__all" href="#" id="mark-all">
                Прочитать все
            </a>
        @endif
    @empty
        Нет не прочитанных уведомлений
    @endforelse
@endsection
@section('page-script')
    <script>
        function sendMarkRequest(id = null) {
            return axios.post('{{ route('profile.notice.read') }}',
                {id: id},
                {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(res=>{
                return res;
            }).catch( err => console.log(err.message))
        }

        $(function () {
            $('.js_makeAsRead').click(async function(){
                let request = await sendMarkRequest($(this).data('id'));
                if(request.data) {
                    $(this).parents('div.alert').remove();
                    const userId = $(this).data('user')
                    document.dispatchEvent(new CustomEvent("noticeRead", {
                        detail: { userId: userId }
                    }));
                }
            });
            $('#mark-all').click(async function () {
                let request = await sendMarkRequest();
                if(request.data) {
                    $('div.alert').remove();
                }
            });
        });
    </script>
@endsection