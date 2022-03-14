@if($errors->any())
<div class="cart-errors">
        <div class="cart-errors__block" role="alert">
            <ul class="cart-errors__ul">
                @foreach($errors->all() as $error)
                    <li class="cart-errors__li">
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
</div>
@endif