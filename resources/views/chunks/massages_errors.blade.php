@if($errors->any())
    <div class="error-block">
        <ul class="error-block__ul">
            {!! implode('', $errors->all('<li class="error-block__li">:message</li>')) !!}
        </ul>
    </div>
@endif
@if(false)
    <div class="massages-block">

        @foreach (['danger', 'warning', 'message', 'success', 'info', 'errors'] as $msg)

            @if(Session::has($msg))

                @if($msg == 'errors')
                    @if(is_array($msg))
                        <p class="alert alert-{{ (trim($msg) == 'errors') ?  'danger' : $msg}}">
                        {{$errors->first()}}
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="alert alert-danger">{{ $errors->first() }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                    @endif


                @else
                    {{$msg}}
                    <p class="alert alert-{{($msg == 'message') ?  'info' : $msg}}">
                        {{ Session::get($msg)}}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </p>
                @endif
            @endif
        @endforeach
    </div>

@endif