@extends('layouts.profile')

@section('content')
    @forelse($notifications as $notification)
        <div class="alert alert-success" role="alert">
            [{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->toFormattedDateString()}}] По Объявлению
            <a href="{{ $notification->data['url'] }}">{{ $notification->data['advert'] }}</a>  был задан вопрос.
            <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                Прочитать
            </a>
        </div>

        @if($loop->last)
            <a href="#" id="mark-all">
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
            $('.mark-as-read').click(async function(){
                let request = await sendMarkRequest($(this).data('id'));
                if(request.data) {
                    $(this).parents('div.alert').remove();
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