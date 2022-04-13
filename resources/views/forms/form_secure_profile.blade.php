<form method="POST" id="post-image" action="{{route('profile.secure.update', $user)}}"
      class="create-form"
      enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    @csrf

    <div class="form-group row">
        <label for="email" class="form-group__placeholder">Почта</label>
        <div class="form-group__inputs">
            <input id="email" type="text"
                   class="form-group__input @error('email') is-invalid @enderror" name="email"
                   value="{{$user->email}}" required autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="form-group__placeholder">Текущий
            пароль</label>
        <div class="form-group__inputs">
            <input id="password" type="text"
                   autocomplete="off"
                   class="form-group__input @error('password') is-invalid @enderror" name="password"
                   value="" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="new_password" class="form-group__placeholder">Новый
            пароль</label>
        <div class="form-group__inputs">
            <input id="new_password" type="text"
                   class="form-group__input @error('new_password') is-invalid @enderror"
                   name="new_password"
                   value="" required
                   autocomplete="off"
            >
            @error('new_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <small id="hint" class="form-group__hint">
                Длина от 8 символов, числа, буквы латинского алфавита и спец. символы @$!%*#?&
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="new_confirm_password" class="form-group__placeholder">Повторите
            пароль</label>
        <div class="form-group__inputs">
            <input id="new_confirm_password" type="text"
                   class="form-group__input @error('new_confirm_password') is-invalid @enderror"
                   name="new_confirm_password"
                   value="" required
                   autocomplete="off"
            >
            @error('new_confirm_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group__actions form-group__single">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn-main btn-middle half">
                Изменить пароль
            </button>
        </div>
    </div>
</form>