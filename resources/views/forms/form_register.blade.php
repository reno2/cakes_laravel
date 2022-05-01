@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="contentCenter">
            <div class="reg-form preloader_central preloader_no_shadow js_ajaxPreloader">

                <div class="reg-form__left">
                    <img class="reg-form__figure" src="{{asset('images/reg.svg')}}" alt="">
                </div>
                <div class="reg-form__right">
                    <div class="reg-form__content">
                        <div class="reg-form__top">
                            <div class="reg-form__sub">присоединяйтесь к нам</div>
                            <div class="reg-form__title">Регистрация</div>
                            <div class="reg-form__login">Уже есть аккаунт?
                                <a class="reg-form__login_link" href="/login">Войти</a>
                            </div>
                        </div>
                        <form class="reg-form_form _js_submit" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="reg-form__group">
                                <label class="form__label" for="email">E-Mail</label>
                                <div class="reg-form__msg">
                                    <input class="form__input @error('email') is-invalid @enderror" id="email"
                                           type="email" name="email" value="{{ old('email') }}" required
                                           autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="reg-form__group">
                                <label class="form__label" for="password">Пароль</label>
                                <div class="reg-form__msg">
                                    <input id="password" type="password"
                                           class="form__input @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <small id="hint" class="form-group__hint">
                                        Длина от 8 символов, числа, буквы латинского алфавита и спец. символы @$!%*#?&
                                    </small>
                                </div>
                            </div>
                            <div class="reg-form__group">
                                <label class="form__label" for="password-confirm">Повторить пароль</label>

                                <div class="reg-form__msg">
                                    <input id="password-confirm" type="password" class="form__input"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="reg-form__group">
                                <div class="reg-form__msg">
                                    <button type="submit" class="btn-big btn-main">
                                        Регистрация
                                    </button>
                                </div>
                            </div>
                            <div class="reg-form__social">
                                <div class="reg-form__subtitle">Войти через соц. сети</div>
                                <div class="reg-form__row">
                                    <a class="btn-half btn-shadow" href="{{ route('login.driver', 'google') }}">
                                        <svg class="i-svg i-svg__md i-svg__bgGrey">
                                            <use xlink:href="/icons/social.svg#google"/>
                                        </svg>
                                    </a>
                                    <a class="btn-half btn-shadow" href="{{ route('login.driver', 'vkontakte') }}">
                                        <svg data-name="" class="i-svg i-svg__md i-svg__bgGrey">
                                            <use xlink:href="/icons/social.svg#vk"></use>
                                        </svg>
                                    </a>
                                    {{--                                <a class="btn-half btn-shadow" href="{{ route('login.driver', 'facebook') }}">--}}
                                    {{--                                    <svg data-name="" class="i-svg i-svg__md i-svg__bgGrey">--}}
                                    {{--                                        <use xlink:href="/icons/social.svg#facebook"></use>--}}
                                    {{--                                    </svg>--}}
                                    {{--                                </a>--}}
                                </div>
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection
