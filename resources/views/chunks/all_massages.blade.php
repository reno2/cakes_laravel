
{{--<div class="flash-message">--}}
{{--    @if (session('status'))--}}
{{--        <div class="alert alert-success" role="alert">--}}
{{--            {{ session('status') }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    @if (session('danger'))--}}
{{--        <div class="alert alert-danger" role="alert">--}}
{{--            {{ session('danger') }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    @if($errors->any())--}}
{{--        @foreach($errors->all() as $error)--}}
{{--        <div class="alert alert-danger" role="alert">--}}
{{--            {{$error}}--}}
{{--            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
{{--        </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</div>--}}


@foreach (['danger', 'warning', 'message', 'success', 'info', 'errors'] as $msg)
    @if(Session::has($msg))
        @if($msg == 'errors' && is_array($msg))

            <p class="alert alert-{{ ($msg == 'errors') ?  'danger' : $msg}}">
            @foreach(Session::get($msg)->getBags() as $bag => $error)
                {{$error->first()}}
            @endforeach
             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @else
            <p class="alert alert-{{($msg == 'message') ?  'info' : $msg}}">
                {{ Session::get($msg)}}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </p>
        @endif
    @endif
@endforeach


