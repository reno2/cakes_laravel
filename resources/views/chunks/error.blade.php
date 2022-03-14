<div class="cart-errors">
    <div class="cart-errors__block" role="alert">


        <ul class="cart-errors__ul">
            @if(is_array($errors))
                @foreach($errors as $error)
                    <li class="cart-errors__li">
                        {{$error}}
                    </li>
                @endforeach
            @else
                <li class="cart-errors__li">
                    {{$errors}}
                </li>
            @endif
        </ul>



    </div>
</div>