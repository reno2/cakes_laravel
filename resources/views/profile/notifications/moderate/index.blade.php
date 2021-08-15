@extends('layouts.profile')

@section('content')
    <div class="notification__top">
        <h2 class="notification__title">
            Уведомления
        </h2>
        <div class="notification__action">
            @if(count($notifications))
                <a class="btn-middle blue notification__read__all js_markAll" href="#" id="mark-all">
                    Прочитать все
                </a>
            @endif
        </div>
    </div>
    <div class="js_notificationUpdate js_ajaxPreloader">
        @include('chunks.notice_moderate')
    </div>
@endsection
@section('page-script')
    <script>
        function sendMarkRequest(id = null) {
            let url;
            if (id) {
                url = '{{ route("profile.notice.read", "id") }}';
                url = url.replace('id', id);
            } else {
                url = '{{ route("profile.notice.read") }}';
            }
            return axios.get(url,
                {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(res => {
                return res;
            }).catch(err => console.log(err.message));
        }


        $(function () {
            // Проичтываем одно сообщение
            $(document).on('click', '.js_makeAsRead', async function (e) {
                e.preventDefault();
                togglePreloader(true);
                let request = await sendMarkRequest($(this).data('id'));
                if (request.data) {
                   // const data = request.data.html();
                    togglePreloader(false);
                    $('.js_notificationUpdate').html(request.data);
                    toggleBlock.init();
                    const userId = $(this).data('user');
                    document.dispatchEvent(new CustomEvent('noticeRead', {
                        detail: {userId: userId}
                    }));
                    // Удаляем кнопку прочитать все
                    if(request.data.length < 200)
                        document.querySelector('.notification__action').remove()

                }

            });

            // Проичтываем все сообщение
            $(document).on('click', '.js_markAll', async function (e) {
                e.preventDefault();
                togglePreloader(true);
                let request = await sendMarkRequest();
                if (request.data) {
                    togglePreloader(false);
                    $('.js_notificationUpdate').html(request.data);
                    document.querySelector('.notification__action').remove()
                }
            });
        });
    </script>
@endsection