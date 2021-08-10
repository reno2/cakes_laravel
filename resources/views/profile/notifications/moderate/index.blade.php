@extends('layouts.profile')

@section('content')
    <div class="notification__top">
        <h2 class="notification__title">
            Уведомления
        </h2>
        <div class="notification__action">
            @isset($notifications)
                <a class="btn-middle blue notification__read__all js_markAll" href="#" id="mark-all">
                    Прочитать все
                </a>
            @endisset
        </div>
    </div>
    @forelse($notifications as $notification)

        <div class="notification js_notificationItem">
            <div class="notification__figure">
                <img class="notification__img" src="/storage/images/defaults/cake.svg" alt="">
            </div>
            <div class="notification__col">
                <div class="notification__message">
                    <div class="notification__from">Администрация
                        [{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->toFormattedDateString()}}]
                    </div>
                    <div class="notification__name">
                        @if(count($notification['data']))
                            <div class="notification__status">Ваше объявление прошло модерацию</div>
                            @if($notification['data']['message'])
                                <div class="notification__mess">
                                    {{$notification["data"]["message"]}}
                                </div>
                            @endif

                            @isset($notification->data['rules'])
                                <ul>
                                @foreach($notification->data['rules'] as $key => $rule)
                                    @isset($rule['title'])
                                    <li>{{$key}} - {{$rule['title']}}</li>
                                    @endisset
                                @endforeach
                                </ul>
                            @endisset

                        @else
                            <div class="notification__status">Ваше объявление прошло модерацию</div>
                        @endif
                    </div>


                </div>
                <div class="notification__link">
                    <a href="#" class="btn-middle blue float-right mark-as-read js_makeAsRead" data-id="{{ $notification['id'] }}" data-user="{{Auth::id()}}">
                        Прочитать
                    </a>
                </div>
                {{--            <a href="/profile/comments/{{ $notification->data['all']['article_id']}}/{{ $notification->data['all']['from_user_id'] }}">{{ $notification->data['advert'] }}</a>  был задан вопрос.--}}

            </div>

        </div>
    @empty

        Нет не прочитанных уведомлений
    @endforelse
    {{ $notifications->links() }}
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
                }).then(res => {
                return res;
            }).catch(err => console.log(err.message));
        }

        $(function () {
            $('.js_makeAsRead').click(async function () {
                let request = await sendMarkRequest($(this).data('id'));
                if (request.data) {
                    $(this).parents('div.js_notificationItem').remove();
                    const userId = $(this).data('user');
                    document.dispatchEvent(new CustomEvent('noticeRead', {
                        detail: {userId: userId}
                    }));
                }
            });
            $('.js_markAll').click(async function () {
                let request = await sendMarkRequest();
                if (request.data) {
                    $('div.alert').remove();
                }
            });
        });
    </script>
@endsection