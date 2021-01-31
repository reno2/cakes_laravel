
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info', 'errors'] as $msg)
        @if(Session::has($msg))
            <p class="alert alert-{{ ($msg == 'errors') ?  'danger' : $msg}}">{{ Session::get($msg)}} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
</div>

