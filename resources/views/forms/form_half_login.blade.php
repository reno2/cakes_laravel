@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="contentCenter">
            <div class="login-form">
                <div class="reg-form__content">
                    <div class="reg-form__top">
                        <div class="reg-form__title">Авторизация</div>
                        <div class="reg-form__login">Ещё нет аккаунта? <a href="/register">Регистрация</a></div>
                    </div>
                    <form class="reg-form_form" method="POST" action="{{ route('login') }}">
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
                            </div>
                        </div>
                        <div class="reg-form__group">
                            <div class="reg-form__msg">
                                <button type="submit" class="btn-big btn-main">
                                    {{ __('Register') }}
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
                                <a class="btn-half btn-shadow" href="{{ route('login.driver', 'facebook') }}">
                                    <svg data-name="" class="i-svg i-svg__md i-svg__bgGrey">
                                        <use xlink:href="/icons/social.svg#facebook"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>
@endsection

