

<div class="container">


    <div class="error-block_half-form">
        @include('chunks.massages_errors')
    </div>

    <div class="contentCenter">

        <div class="login-form preloader_central preloader_no_shadow js_ajaxPreloader">
            <div class="reg-form__content">
                <div class="reg-form__top">
                    <div class="reg-form__title">Сброс пароля</div>
                    <div class="reg-form__login">Ещё нет аккаунта? <a class="reg-form__register_link" href="/register">Регистрация</a></div>
                </div>
                <form class="reg-form_form js_loading" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="reg-form__group">
                        <label class="form__label" for="email">E-Mail</label>
                        <div class="reg-form__msg">
                            <input class="form__input @error('email') is-invalid @enderror" id="email"
                                   type="email" name="email" value="{{ $email ?? old('email') }}" required
                                   autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="reg-form__group">
                        <label for="password" class="form__label">Новый пароль</label>

                        <div class="reg-form__msg">
                            <input id="password" type="password"
                                   class="form__input @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password">

                            <div class="reg-form__msg">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            </div>
                        </div>
                    </div>

                    <div class="reg-form__group">
                        <label for="password_confirmation" class="form__label">Подтверждение пароль</label>

                        <div class="reg-form__msg">
                            <input id="password_confirmation" type="password"
                                   class="form__input @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation"
                                   required autocomplete="new-password">

                            <div class="reg-form__msg">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            </div>
                        </div>
                    </div>


                    <div class="reg-form__group">
                        <div class="reg-form__msg">
                            <button type="submit" class="btn-big btn-main">
                                Отправить
                            </button>
                        </div>
                    </div>

                    @if(config('services.google_recaptcha.recaptcha_status'))
                        <div class="captcha">
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            <div class="captcha__info">Защищён reCAPTCHA Google</div> |
                            <a class="captcha__link" href="https://policies.google.com/privacy">Privacy Policy</a> |
                            <a class="captcha__link" href="https://policies.google.com/terms">Terms of Service</a>
                        </div>
                    @endif
                </form>
            </div>


        </div>

    </div>
</div>


